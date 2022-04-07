<?php

declare(strict_types=1);

return [
    'db' => [
        'driver'  => 'pdo_mysql',
        'host'    => 'localhost',
        'port'    => 3306,
        'user'    => 'core',
        'pass'    => 'core',
        'name'    => 'core',
        'charset' => 'utf8',
    ],
    'orm' => [
        'proxy_path'            => __DIR__.'/../Orm/Proxy/',
        'proxy_namespace'       => 'Core\\Orm\\Proxy',
        'entity_path'           => __DIR__.'/../Orm/Entity/',
        'auto_generate_proxies' => true,
    ],
    'debug' => [
        'enabled'   => true,
        'logs_path' => __DIR__.'/../Logs',
        'loglevel'  => 7,
    ],
    'core' => [
        'name'         => 'Core Test',
        'name_short'   => 'Core',
        'version'      => '1.0.0 dev',
        'secret'       => [
            'key' => 'f4ef74r89g41954r89g',
            'random_iv' => false,
        ],
        'base_url'     => 'http://localhost/',
        'encrypt_url'  => false,
        'root'         => __DIR__.'/../',
        'assets'       => '/assets',
        'static'       => '/static',
        'cache'        => __DIR__.'/../Cache',
        'template'     => __DIR__.'/../Views',
        'template_ext' => '.twig',
    ],
    'mail' => [
        'blacklist' => [
            'example.com',
            'spam@local.host',
        ],
    ],
    'imprint' => [
        'name'    => 'Max Mustermann',
        'address' => 'Teststreet 1',
        'zip'     => '12345',
        'city'    => 'Testcity',
        'country' => 'Testcountry',
        'email'   => 'test@local.host',
    ],
];
