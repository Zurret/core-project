<?php

declare(strict_types=1);

namespace Core\Module\Core;

use Core\Lib\Auth;
use Core\Lib\Request;
use Core\Lib\Session;
use Core\Orm\Entity\UserInterface;
use Core\Orm\Repository\UserRepositoryInterface;
use Exception;
use Noodlehaus\ConfigInterface;

final class CoreController implements CoreControllerInterface
{
    private ConfigInterface $config;

    private TemplateInterface $template;

    private Auth $auth;

    private Session $session;

    private ?UserInterface $user = null;

    private ?UserRepositoryInterface $userRepository = null;

    private array $notification = [];

    private $app;

    public function __construct(
        ConfigInterface $config,
        TemplateInterface $template,
        Auth $auth,
        Session $session,
        ?UserRepositoryInterface $userRepository
    ) {
        $this->config = $config;
        $this->template = $template;
        $this->auth = $auth;
        $this->session = $session;
        $this->userRepository = $userRepository;

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
        $this->setTemplateVar('auth', $this->Auth());
        $this->setTemplateVar('user', $this->getUser());
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

    public function Auth(): Auth
    {
        return $this->auth;
    }

    public function getUser(): ?UserInterface
    {
        return $this->Auth()->getUser();
    }

    public function Session(): Session
    {
        return $this->session;
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
        return $this->app->getContainer()->get('container.'.$contrainer);
    }

    public function setNotification(mixed $notification): void
    {
        $this->notification[] = $notification;
        $this->session->set('INFOS', $this->notification);
    }

    public function getNotification(): ?array
    {
        $return = $this->session->get('INFOS');
        $this->session->delete('INFOS');

        return $return;
    }

    public function setToken(): void
    {
        $this->session->set('TOKEN', bin2hex(random_bytes(32)));
    }

    public function getToken(): ?string
    {
        if ($this->session->get('TOKEN') === null) {
            $this->setToken();
        }

        return $this->session->get('TOKEN');
    }

    public function checkToken(): bool
    {
        if (Request::postString('TOKEN') === $this->session->get('TOKEN')) {
            $this->setToken();

            return true;
        }

        $this->setToken();

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

    public function redirect(string $url): void
    {
        header('Location: '.$url);
        exit;
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
