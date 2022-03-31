<?php

declare(strict_types=1);

session_start();
ini_set('date.timezone', 'Europe/Berlin');

require_once __DIR__.'/../_vendor/autoload.php';
require_once __DIR__.'/ErrorHandler.php';

 $app = new Core\App\App();
 $app->run();

 return $app;
