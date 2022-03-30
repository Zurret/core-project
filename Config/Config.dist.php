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
    'game' => [
        'name'    => 'Core Test',
        'root'    => __DIR__.'/../',
        'tmp_dir' => __DIR__.'/../Cache',
    ],
];
