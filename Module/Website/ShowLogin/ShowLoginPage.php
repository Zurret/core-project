<?php

declare(strict_types=1);

namespace Core\Module\Website\ShowLogin;

use Core\Lib\Helper;
use Core\Lib\Request;
use Core\Module\Core\CoreControllerInterface;
use Core\Orm\Repository\UserRepositoryInterface;

class ShowLoginPage
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
     * __invoke
     *
     * @return void
     */
    public function __invoke(): void
    {
        $this->core->setTemplateTitle('Login');
        $this->core->setTemplateFile('Index/Login.twig');
        $this->core->render();
    }
    
    /**
     * doLogout
     *
     * @param  mixed $token
     * @return void
     */
    public function doLogout(string $token): void
    {
        if ($this->core->getToken() == $token) {
            $this->core->setNotification('Logout erfolgreich.');
            $this->core->Auth()->logout();
        } else {
            $this->core->setNotification('Logout fehlgeschlagen.');
            $this->__invoke();
        }
    }
    
    /**
     * doLogin
     *
     * @return void
     */
    public function doLogin(): void
    {
        if ($this->core->checkToken()) {
            $email = Request::postString('email');
            $password = Request::postString('password');
            if ($this->checkLogin($email, $password)) {
                $this->core->redirect('/game/maindesk');
            } else {
                $this->core->redirect('/');
            }
        }
        $this->core->setNotification('Token nicht gültig');
        $this->core->redirect('/');
    }
    
    /**
     * checkLogin
     *
     * @param  mixed $email
     * @param  mixed $password
     * @return bool
     */
    private function checkLogin(string $email, string $password): bool
    {
        if (!Helper::checkEmail($email)) {
            $this->core->setNotification('Keine gültige E-Mail Adresse.');

            return false;
        }
        $result = $this->userRepository->getByEmail($email);
        if ($result === null) {
            $this->core->setNotification('Es gibt keinen Account mit dieser E-Mail Adresse');

            return false;
        }
        if (!$this->core->Auth()->checkPassword($password, $result->getPassword())) {
            $this->core->setNotification('Das Passwort stimmt nicht.');

            return false;
        }
        
        if($this->core->Auth()->login($email, $password)) {
            $this->core->setNotification('Login erfolgreich');
            return true;
        } else {
            $this->core->setNotification('Login fehlgeschlagen');
            return false;
        }
    }
}
