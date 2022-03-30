<?php

declare(strict_types=1);

namespace Core\Module\Core;

use Core\Lib\Session;
use Exception;
use Noodlehaus\ConfigInterface;

final class CoreController implements CoreControllerInterface
{
    private ConfigInterface $config;

    private TemplateInterface $template;

    private array $notification = [];

    public function __construct(
        ConfigInterface $config,
        TemplateInterface $template
    ) {
        $this->config = $config;
        $this->template = $template;
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
        $this->setTemplateVar('benchmark', $this->getBenchmarkResult());
        $this->setTemplateVar('infos', $this->getNotification());
        /**
         * Render page.
         */
        ob_start();
        echo $this->template->parse();
        ob_end_flush();
    }

    public function getCoreName(): string
    {
        return $this->getConfig('game.name');
    }

    public function getConfig(string $var): mixed
    {
        return $this->config->get($var) ?? null;
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

    public function setTemplateFile(string $tpl): void
    {
        $this->template->setTemplate($tpl);
    }

    public function setTemplateVar(string $key, $variable): void
    {
        $this->template->setVar($key, $variable);
    }

    public function setTemplateTitle(string $variable): void
    {
        $this->setTemplateVar('title', $variable.' - '.$this->getCoreName());
    }

    private function getVersion(): string
    {
        return '1.0.0 dev';
    }

    /**
     * @throws Exception
     */
    private function getBenchmarkResult(): array
    {
        global $bench;
        $bench->end();

        return [
            'executionTime'   => $bench->getTime(),
            'memoryUsage'     => $bench->getMemoryUsage(),
            'memoryPeakUsage' => $bench->getMemoryPeak(),
        ];
    }
}
