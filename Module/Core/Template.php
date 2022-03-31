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
        if ($this->template === null) {
            if (!isset($this->template)) {
                $loader = new FilesystemLoader($this->config->get('core.root').'/View/');
                if (!$this->config->get('debug.enabled')) {
                    $this->template = new Environment($loader, [
                        'cache' => $this->config->get('core.tmp_dir'),
                    ]);
                } else {
                    $this->template = new Environment($loader);
                }
            }
        }
        $this->setFilter();

        return $this->template;
    }
}
