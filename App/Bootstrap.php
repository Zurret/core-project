<?php

declare(strict_types=1);

session_name('core_session');
session_start();

ini_set('date.timezone', 'Europe/Berlin');

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Core\App\App();
$app->run();

require_once __DIR__ . '/../Lib/ErrorHandler.php';
require_once __DIR__ . '/../Lib/Helper.php';

return $app;
