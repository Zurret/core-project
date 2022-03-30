<?php

declare(strict_types=1);

namespace Core\App;

use Core\Lib\Ubench;
use DI\ContainerBuilder;
use Exception;

session_start();
ini_set('date.timezone', 'Europe/Berlin');

require_once __DIR__.'/../_vendor/autoload.php';

$bench = new Ubench();
$bench->start();

$containerBuilder = new ContainerBuilder();
try {
    $container = $containerBuilder->addDefinitions(__DIR__ . '/Config.php')->build();
} catch (Exception $e) {
    /**
     * Wenn das passiert, ist ein die() sinnvoller als alles andere.
     */
    die($e->getMessage());
}

require_once __DIR__.'/ErrorHandler.php';

return $container;
