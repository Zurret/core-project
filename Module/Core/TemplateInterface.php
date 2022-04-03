<?php

declare(strict_types=1);

namespace Core\Module\Core;

interface TemplateInterface
{
    public function setVar(string $var, $value): void;

    public function setTemplate(string $file): void;

    public function isTemplateSet(): bool;

    public function parse(): string;
    
    public function generateUrl(string $url): string;
}
