<?php

declare(strict_types=1);

return [
    'db' => [
        'host'            => 'localhost',
        'port'            => 3306,
        'user'            => 'core',
        'pass'            => 'core',
        'name'            => 'core',
        'proxy_namespace' => 'Core\\Orm\\Proxy',
    ],
    'debug' => [
        'enabled'   => true,
        'logs_path' => __DIR__.'/../Logs',
        'loglevel'  => 7,
    ],
    'core' => [
        'name'     => 'Core Test',
        'version'  => '1.0.0 dev',
        'secret'   => 'd4d89w48494g894ht9r&4f89e',
        'root'     => __DIR__.'/../',
        'cache'    => __DIR__.'/../Cache',
        'template' => __DIR__.'/../Views',
    ],
];
