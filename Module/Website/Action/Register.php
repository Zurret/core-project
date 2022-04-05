<?php

declare(strict_types=1);

namespace Core\Module\Website\Action;

use Core\Lib\Request;
use Core\Module\Core\CoreControllerInterface;
use Core\Orm\Repository\PlayerRepositoryInterface;
use Core\Orm\Repository\UserRepositoryInterface;
use Exception;

class Register
{
    private CoreControllerInterface $core;

    private UserRepositoryInterface $userRepository;

    private PlayerRepositoryInterface $playerRepository;

    public function __construct(
        CoreControllerInterface $core,
        UserRepositoryInterface $userRepository,
        PlayerRepositoryInterface $playerRepository
    ) {
        $this->core = $core;
        $this->userRepository = $userRepository;
        $this->playerRepository = $playerRepository;
    }

    /**
     * @route POST /auth/register
     *
     * @throws Exception
     */
    public function doRegistration(): void
    {
        if ($this->core->checkToken()) {
            $email = Request::postString('email');
            $password = Request::postString('password');
            $password_confirm = Request::postString('password_confirm');

            if ($this->createAccount($email, $password, $password_confirm)) {
                $this->core->setNotification('Account erfolgreich erstellt.');
                $this->core->redirect('/auth/login');
            } else {
                $this->core->setNotification('Account konnte nicht erstellt werden.');
                $this->core->redirect('/auth/register');
            }
        }
    }

    private function createAccount(string $email, string $password, string $password_confirm): bool
    {
        if (!checkEmail($email)) {
            $this->core->setNotification('Email ist ungültig.');

            return false;
        }

        // Check if email or email domain is on blacklist
        if ($this->isEmailBlacklisted($email)) {
            $this->core->setNotification('E-Mail Adresse ist auf der Blacklist.');

            return false;
        }

        if ($this->userRepository->getByEmail($email)) {
            $this->core->setNotification('E-Mail Adresse bereits vergeben.');

            return false;
        }

        if ($password !== $password_confirm) {
            $this->core->setNotification('Passwörter stimmen nicht überein.');

            return false;
        }

        $account = $this->userRepository->prototype();
        $player = $this->playerRepository->prototype();
        $account->setEmail($email);
        $account->setPassword($this->core->Auth()->hashPassword($password));
        $player->setName('Kolonist');
        $this->playerRepository->save($player);
        $account->setPlayer($player);
        $this->userRepository->save($account);

        return true;
    }

    private function isEmailBlacklisted(string $email): bool
    {
        $email_domain = explode('@', $email)[1];
        $blacklist = $this->core->getConfig('mail.blacklist');

        if (in_array($email, $blacklist)) {
            return true;
        }

        if (in_array($email_domain, $blacklist)) {
            return true;
        }

        return false;
    }
}
