<?php

declare(strict_types=1);

namespace Core\Module\Core;

use Core\Lib\Helper;
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

    private function setFilterAndFunction(): void
    {
        $this->template->addFunction(new \Twig\TwigFunction(
            'encrypt',
            function ($src, $key = null): string {
                if (is_null($key)) {
                    $key = $this->config->get('core.secret');
                }

                return Helper::encrypt((string) $src, (string) $key);
            }
        ));

        $this->template->addFunction(new \Twig\TwigFunction(
            'decrypt',
            function ($src, $key = null): string {
                if (is_null($key)) {
                    $key = $this->config->get('core.secret');
                }

                return Helper::decrypt((string) $src, (string) $key);
            }
        ));

        $this->template->addFunction(new \Twig\TwigFunction(
            'url',
            function ($src): string {
                if ($this->config->get('core.encrypt_url')) {
                    return (string) $this->config->get('core.base_url').Helper::encrypt($src, $this->config->get('core.secret'));
                } else {
                    return (string) $src;
                }
            }
        ));

        $this->template->addFunction(new \Twig\TwigFunction(
            'removeHTML',
            function ($src): string {
                return Helper::removeHTML((string) $src);
            }
        ));

        $this->template->addFunction(new \Twig\TwigFunction(
            'isPositivInteger',
            function ($src): bool {
                return Helper::isPositivInteger((int) $src);
            }
        ));

        $this->template->addFunction(new \Twig\TwigFunction(
            'isNegativeInteger',
            function ($src): bool {
                return Helper::isNegativeInteger((int) $src);
            }
        ));
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

        $this->setFilterAndFunction();

        return $this->template;
    }
}
