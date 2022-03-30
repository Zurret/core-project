<?php

declare(strict_types=1);

namespace Core\Module\Website\ShowRegistration;

use Core\Lib\Request;
use Core\Module\Core\CoreControllerInterface;
use Exception;

class ShowRegistrationPage
{
    private CoreControllerInterface $_core;

    public function __construct(CoreControllerInterface $_core)
    {
        $this->_core = $_core;
    }

    /**
     * @route GET /register
     */
    public function __invoke(): void
    {
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
        $test = (string) Request::postString('test');
        $this->_core->setNotification($test);
        $this->_core->setNotification('dsadt');
        $this->_core->setNotification('dsafdsfsddt');
        $this->__invoke();
    }
}
