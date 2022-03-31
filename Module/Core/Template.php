<?php

declare(strict_types=1);

namespace Core\Module\Core;

use Noodlehaus\ConfigInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

final class Template implements TemplateInterface
{
    private ConfigInterface $config;

    private $template;

    private array $variables = [];

    private $isTemplateSet;

    public function __construct(
        ConfigInterface $config
    ) {
        $this->config = $config;
    }

    public function setVar(string $var, $value): void
    {
        $this->variables[$var] = $value;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function setTemplate(string $file): void
    {
        $this->isTemplateSet = $this->getTemplate()->load($file);
    }

    public function isTemplateSet(): bool
    {
        return isset($this->isTemplateSet);
    }

    public function parse(): string
    {
        return $this->isTemplateSet->render($this->variables);
    }

    private function setFilter(): void
    {
        /**
         * $this->template->addFilter(new \Twig\TwigFilter(
         *     'clmodeDescription',
         *     function ($src): string {
         *         return TemplateHelper::getContactListModeDescription((int) $src);
         *     }
         * ));.
         */
    }

    private function getTemplate(): Environment
    {
        if (isset($this->template)) {
            return $this->template;
        }

        $this->template = new Environment(
            new FilesystemLoader($this->config->get('core.template')),
            [
                'cache' => $this->config->get('debug.enabled') ? false : $this->config->get('core.cache'),
            ]
        );

        $this->setFilter();

        return $this->template;
    }

}
