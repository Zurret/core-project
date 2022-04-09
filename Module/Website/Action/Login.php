<?php

declare(strict_types=1);

namespace Core\Module\Website\Action;

use Core\Lib\Request;
use Core\Module\Core\CoreControllerInterface;
use Core\Orm\Repository\AccountRepositoryInterface;

class Login
{
    private CoreControllerInterface $core;

    private AccountRepositoryInterface $accountRepository;

    public function __construct(
        AccountRepositoryInterface $accountRepository,
        CoreControllerInterface $core
    ) {
        $this->accountRepository = $accountRepository;
        $this->core = $core;
    }

    /**
     * doLogin.
     */
    public function doLogin(): void
    {
        if ($this->core->checkToken()) {
            $email = Request::postString('email');
            $password = Request::postString('password');
            $save_login = Request::postBool('saveLogin');

            if ($this->checkLogin($email, $password, $save_login)) {
                $this->core->redirect('/game/maindesk');
            } else {
                $this->core->redirect('/');
            }
        }
        $this->core->setNotification('Token nicht gültig');
        $this->core->redirect('/');
    }

    /**
     * checkLogin.
     *
     * @param mixed $email
     * @param mixed $password
     */
    private function checkLogin(string $email, string $password, bool $save_login): bool
    {
        if (!checkEmail($email)) {
            $this->core->setNotification('Email ungültig');

            return false;
        }
        $result = $this->accountRepository->getByEmail($email);
        if ($result === null) {
            $this->core->setNotification('E-Mail Adresse nicht gefunden.');

            return false;
        }
        if (!$this->core->Auth()->checkPassword($password, $result->getPassword())) {
            $this->core->setNotification('Passwort falsch.');

            return false;
        }

        if ($this->core->Auth()->login($email, $password, $save_login)) {
            $this->core->setNotification('Login erfolgreich');

            return true;
        }
        $this->core->setNotification('Login fehlgeschlagen');

        return false;
    }
}
