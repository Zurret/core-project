<?php

declare(strict_types=1);

namespace Core\Module\Website\ShowLogin;

use Core\Lib\Auth;
use Core\Lib\Request;
use Core\Lib\Helper;
use Core\Module\Core\CoreControllerInterface;
use Core\Orm\Repository\UserRepositoryInterface;

class ShowLoginPage
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

    public function __invoke(): void
    {
        $this->_core->setTemplateTitle('Login');
        $this->_core->setTemplateFile('Index/Login.twig');
        $this->_core->render();
    }

    public function doLogout(string $token): void
    {
        if ($this->_core->getToken() == $token) {
            $this->_core->setNotification('Logout erfolgreich.');
            Auth::logout();
        } else {
            $this->_core->setNotification('Logout fehlgeschlagen.');
            $this->__invoke();
        }
    }

    public function doLogin(): void
    {
        if ($this->_core->checkToken()) {
            $email = Request::postString('email');
            $password = Request::postString('password');

            if ($this->checkLogin($email, $password)) {
                $this->_core->setNotification('Login erfolgreich');
            }
        }
        header('Location: /');
    }

    private function checkLogin(string $email, string $password): bool
    {
        if (!Helper::checkEmail($email)) {
            $this->_core->setNotification('Keine gültige E-Mail Adresse.');

            return false;
        }
        $result = $this->userRepository->getByEmail($email);
        if ($result === null) {
            $this->_core->setNotification('Es gibt keinen Account mit dieser E-Mail Adresse');

            return false;
        }
        if (!Auth::checkPassword($password, $result->getPassword())) {
            $this->_core->setNotification('Das Passwort stimmt nicht.');

            return false;
        }

        $result->setSession(Auth::hashPassword(microtime().'-'.$result->getId()));
        $this->userRepository->save($result);
        Auth::doLogin($result);

        return true;
    }
}
