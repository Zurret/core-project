<?php

declare(strict_types=1);

namespace Core\Module\Website\ShowLogin;

use Core\Lib\Request;
use Core\Lib\Auth;
use Core\Module\Core\CoreControllerInterface;
use Core\Orm\Repository\UserRepositoryInterface;
use Exception;

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

    /**
     * @route GET /register
     */
    public function __invoke(): void
    {
        $this->_core->setTemplateTitle('Login');
        $this->_core->setTemplateFile('Index/Login.twig');
        $this->_core->render();
    }

    /**
     * @route POST /register
     *
     * @throws Exception
     */
    public function doLogin(): void
    {
        if ($this->_core->checkToken()) {
            $email = Request::postString('email');
            $password = Request::postString('password');

            if ($this->checkLogin($email, $password)) {
                $this->_core->setNotification('Login erfolgreich');
            }
        }
        $this->__invoke();
    }

    private function checkLogin(string $email, string $password): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
