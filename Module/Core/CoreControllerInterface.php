<?php

declare(strict_types=1);

namespace Core\Module\Core;

interface CoreControllerInterface
{
    public function setNotification(string $notification): void;

    public function getNotification(): ?array;

    public function setTemplateFile(string $tpl): void;

    public function setTemplateVar(string $key, $variable): void;

    public function setTemplateTitle(string $variable): void;
    
    public function getConfig(string $var): mixed;

    public function render(): void;
}
