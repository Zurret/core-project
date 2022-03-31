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
        'name'    => 'Core Test',
        'version' => '1.0.0 dev',
        'root'    => __DIR__.'/../',
        'tmp_dir' => __DIR__.'/../Cache',
    ],
];
