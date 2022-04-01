<?php

declare(strict_types=1);

namespace Core\Module\Website\Action;

use Core\Lib\Helper;
use Core\Lib\Request;
use Core\Module\Core\CoreControllerInterface;
use Core\Orm\Repository\UserRepositoryInterface;

class Login
{
    private CoreControllerInterface $core;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        CoreControllerInterface $core
    ) {
        $this->userRepository = $userRepository;
        $this->core = $core;
    }

    /**
     * doLogin.
     *
     * @return void
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
     *
     * @return bool
     */
    private function checkLogin(string $email, string $password, bool $save_login): bool
    {
        if (!Helper::checkEmail($email)) {
            $this->core->setNotification('Email ungültig');

            return false;
        }
        $result = $this->userRepository->getByEmail($email);
        if ($result === null) {
            $this->core->setNotification('E-Mail Adresse nicht gefunden.');

            return false;
        }
        if (!$this->core->Auth()->checkPassword($password, $result->getPassword())) {
            $this->core->setNotification('Passwort falsch.');

            return false;
        }

        if ($this->core->Auth()->login($email, $password)) {
            $this->core->setNotification('Login erfolgreich');

            return true;
        } else {
            $this->core->setNotification('Login fehlgeschlagen');

            return false;
        }
    }
}
