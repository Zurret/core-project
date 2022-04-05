<?php

declare(strict_types=1);

namespace Core\Module\Core;

use Noodlehaus\ConfigInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

final class Template implements TemplateInterface
{
    private ConfigInterface $config;

    private $template;

    private array $variables = [];

    private $isTemplateSet;

    private string $version;

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
        $this->isTemplateSet = $this->getTemplate()->load($file . $this->config->get('core.template_ext'));
    }

    public function isTemplateSet(): bool
    {
        return isset($this->isTemplateSet);
    }

    public function parse(): string
    {
        return $this->isTemplateSet->render($this->variables);
    }

    private function getV(): string
    {
        if (!isset($this->version)) {
            $this->version = substr(md5($this->config->get('core.version')), 0, 12);
        }
        return $this->version;
    }

    public function generateUrl(string $url): string
    {
        if ($this->config->get('core.encrypt_url')) {
            $url = $this->config->get('core.base_url') . encrypt($url, $this->config->get('core.secret'));
        } else {
            $url = $this->config->get('core.base_url') . $url;
        }
        return $url;
    }

    private function setFilterAndFunction(): void
    {
        $this->template->addFunction(new TwigFunction(
            'assetsPath',
            function ($src): string {
                return $this->config->get('core.assets') . '/' . $src . '?v=' . $this->getV();
            }
        ));

        $this->template->addFunction(new TwigFunction(
            'staticPath',
            function ($src): string {
                return $this->config->get('core.static') . '/' . $src . '?v=' . $this->getV();
            }
        ));

        $this->template->addFunction(new TwigFunction(
            '__',
            function (string $string, ?array $value = null): string {
                return __($string, $value);
            }
        ));

        $this->template->addFunction(new TwigFunction(
            'encrypt',
            function ($src, $key = null): string {
                if (is_null($key)) {
                    $key = $this->config->get('core.secret');
                }

                return encrypt((string) $src, (string) $key);
            }
        ));

        $this->template->addFunction(new TwigFunction(
            'decrypt',
            function ($src, $key = null): string {
                if (is_null($key)) {
                    $key = $this->config->get('core.secret');
                }

                return decrypt((string) $src, (string) $key);
            }
        ));

        $this->template->addFunction(new TwigFunction(
            'internUrl',
            function ($src): string {
                return $this->generateUrl($src);
            }
        ));

        $this->template->addFunction(new TwigFunction(
            'removeHTML',
            function ($src): string {
                return removeHTML((string) $src);
            }
        ));

        $this->template->addFunction(new TwigFunction(
            'isPositivInteger',
            function ($src): bool {
                return isPositivInteger((int) $src);
            }
        ));

        $this->template->addFunction(new TwigFunction(
            'isNegativeInteger',
            function ($src): bool {
                return isNegativeInteger((int) $src);
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
