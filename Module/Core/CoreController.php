<?php

declare(strict_types=1);

namespace Core\Module\Core;

use Core\Lib\Auth;
use Core\Lib\Request;
use Core\Lib\Session;
use Core\Orm\Entity\UserInterface;
use Exception;
use Noodlehaus\ConfigInterface;

final class CoreController implements CoreControllerInterface
{
    private ConfigInterface $config;

    private TemplateInterface $template;

    private ?UserInterface $user = null;

    private array $notification = [];

    private $app;

    public function __construct(
        ConfigInterface $config,
        TemplateInterface $template
    ) {
        $this->config = $config;
        $this->template = $template;
        
        global $app;
        $this->app = $app;
    }

    /**
     * @throws Exception
     */
    public function render(): void
    {
        /**
         * Global variable.
         */
        $this->setTemplateVar('core_name', $this->getCoreName());
        $this->setTemplateVar('core_version', $this->getVersion());
        $this->setTemplateVar('core_account', $this->getUser());
        $this->setTemplateVar('core_token', $this->getToken());
        $this->setTemplateVar('token_form', $this->getTokenInput());
        $this->setTemplateVar('benchmark', $this->getBenchmarkResult());
        $this->setTemplateVar('infos', $this->getNotification());

        /**
         * Render page.
         */
        ob_start();
        echo $this->template->parse();
        ob_end_flush();
    }

    public function getUser(): ?UserInterface
    {
        if ($this->user === null) {
            $this->user = Auth::loadUser();
        }

        return $this->user;
    }

    public function onlyForPlayers(): void
    {
        Auth::checkAccessLevel(1, $this->getUser());
    }

    public function onlyForNpc(): void
    {
        Auth::checkAccessLevel(2, $this->getUser());
    }

    public function onlyForAdmin(): void
    {
        Auth::checkAccessLevel(99, $this->getUser());
    }

    public function getCoreName(): string
    {
        return $this->getConfig('core.name');
    }

    public function getConfig(string $var): mixed
    {
        return $this->config->get($var) ?? null;
    }

    public function getContainer(string $contrainer): mixed
    {
        return $this->app->getContainer()->get('container.' . $contrainer);
    }

    public function setNotification(mixed $notification): void
    {
        $this->notification[] = $notification;
        Session::setSession('INFOS', $this->notification);
    }

    public function getNotification(): ?array
    {
        $return = Session::getSession('INFOS');
        Session::delSession('INFOS');

        return $return;
    }

    public function setToken(): void
    {
        Session::setSession('TOKEN', sha1(rand(0, 100).microtime().rand(0, 100)));
    }

    public function getToken(): string
    {
        if (Session::checkSessionExist('TOKEN')) {
            $this->setToken();
        }

        return Session::getSession('TOKEN');
    }

    public function checkToken(): bool
    {
        if (Request::getPostParam('TOKEN') === Session::getSession('TOKEN')) {
            $this->setToken();

            return true;
        }

        $this->setToken();
        $this->setNotification('Token invalide');

        return false;
    }

    public function getTokenInput(): string
    {
        return '<input type="hidden" name="TOKEN" value="'.$this->getToken().'" required>';
    }

    public function setTemplateFile(string $tpl): void
    {
        $this->template->setTemplate($tpl);
    }

    public function setTemplateVar(string $key, mixed $variable): void
    {
        $this->template->setVar($key, $variable);
    }

    public function setTemplateTitle(string $variable): void
    {
        $this->setTemplateVar('page_title', $variable.' - '.$this->getCoreName());
        $this->setTemplateVar('site_title', $variable);
    }

    private function getVersion(): string
    {
        return $this->getConfig('core.version');
    }

    /**
     * @throws Exception
     */
    private function getBenchmarkResult(): array
    {
        $this->app->getBenchmark()->end();

        return [
            'executionTime'   => $this->app->getBenchmark()->getTime(),
            'memoryUsage'     => $this->app->getBenchmark()->getMemoryUsage(),
            'memoryPeakUsage' => $this->app->getBenchmark()->getMemoryPeak(),
        ];
    }
}
