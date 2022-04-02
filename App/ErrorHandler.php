<?php

declare(strict_types=1);

use Noodlehaus\ConfigInterface;
use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

$config = $app->getContainer()->get(ConfigInterface::class);
$whoops = new Run();

$logger = new Monolog\Logger('core');
$logger->pushHandler(
    new Monolog\Handler\StreamHandler($config->get('debug.logs_path').'/'.date('d.m.Y').'.log')
);

// Function to create a hash of the error message
function error_hash(string $message): string
{
    return '['.substr(hash('sha256', $message), 0, 12).']';
}

if ($config->get('debug.enabled')) {
    error_reporting(E_ALL & ~E_NOTICE);

    if (Whoops\Util\Misc::isCommandLine()) {
        $handler = new PlainTextHandler();
    } else {
        $handler = new PrettyPageHandler();
        $handler->setEditor('vscode');
        $handler->setPageTitle('Error - '.$config->get('core.name'));
        $handler->addDataTable('Core', [
            'Core Version'  => $config->get('core.version'),
            'Core Name'     => $config->get('core.name'),
            'Core Secret'   => $config->get('core.secret'),
            'Core Root'     => $config->get('core.root'),
            'Core Logs'     => $config->get('debug.logs_path'),
            'Core Cache'    => $config->get('core.cache'),
            'Core Template' => $config->get('core.template'),
        ]);
    }

    $whoops->prependHandler($handler);
} else {
    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    if (Whoops\Util\Misc::isCommandLine()) {
        $handler = new PlainTextHandler();
    } else {
        $handler = function (Throwable $e, $inspector, $run) {
            // Create a Error HTML page
            echo '<html><head><title>Error</title></head><body>';
            echo '<p>'.error_hash($e->getMessage()).' - '.$e->getMessage().'</p>';
            echo '</body></html>';
        };
    }
    $whoops->prependHandler($handler);
}

$whoops->prependHandler(function (Throwable $e, $inspector, $run) use ($logger) {
    $logger->error(
        error_hash($e->getMessage()).' - '.$e->getMessage(),
        [
            'file'  => $e->getFile(),
            'line'  => $e->getLine(),
            'trace' => $e->getTrace(),
        ]
    );
});
$whoops->register();

// Test the error handler
// throw new Exception("Something broke!");
