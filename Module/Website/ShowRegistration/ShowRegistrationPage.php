<?php

declare(strict_types=1);

namespace Core\Module\Website\ShowRegistration;

use Core\Lib\Auth;
use Core\Lib\Request;
use Core\Module\Core\CoreControllerInterface;
use Core\Orm\Repository\UserRepositoryInterface;
use Exception;

class ShowRegistrationPage
{
    private CoreControllerInterface $_core;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        CoreControllerInterface $_core
    ) {
        $this->userRepository = $userRepository;
        $this->_core = $_core;
    }

    /**
     * @route GET /register
     */
    public function __invoke(): void
    {
        Auth::checkAccess();
        $this->_core->setTemplateTitle('Registration');
        $this->_core->setTemplateFile('Index/Registration.twig');
        $this->_core->render();
    }

    /**
     * @route POST /register
     *
     * @throws Exception
     */
    public function doRegistration(): void
    {
        if ($this->_core->checkToken()) {
            $email = Request::postString('email');
            $password = Request::postString('password');
            $password_confirm = Request::postString('password_confirm');

            if ($this->createAccount($email, $password, $password_confirm)) {
                $this->_core->setNotification('Account wurde erstellt.');
            }
        }
        $this->__invoke();
    }

    private function createAccount(string $email, string $password, string $password_confirm): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->_core->setNotification('Keine gültige E-Mail Adresse.');

            return false;
        }

        if ($this->userRepository->getByEmail($email)) {
            $this->_core->setNotification('Diese E-Mail Adresse hat schon einen Account');

            return false;
        }

        if ($password !== $password_confirm) {
            $this->_core->setNotification('Passwörter stimmen nicht überein.');

            return false;
        }

        $account = $this->userRepository->prototype();
        $account->setEmail($email);
        $account->setPassword(Auth::hashPassword($password));
        $this->userRepository->save($account);

        return true;
    }
}
