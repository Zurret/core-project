<?php

declare(strict_types=1);

use Cache\Adapter\PHPArray\ArrayCachePool;
use Core\Module\Core\CoreController;
use Core\Module\Core\CoreControllerInterface;
use Core\Module\Core\Template;
use Core\Module\Core\TemplateInterface;
use function DI\autowire;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Noodlehaus\Config;
use Noodlehaus\ConfigInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Container\ContainerInterface;

return [
    ConfigInterface::class => static function (): ConfigInterface {
        $path = __DIR__.'/../Config/';

        return new Config(
            [
                sprintf('%s/Config.dist.php', $path),
                sprintf('?%s/Config.php', $path),
            ]
        );
    },
    CacheItemPoolInterface::class => static function (): CacheItemPoolInterface {
        return new ArrayCachePool();
    },
    EntityManagerInterface::class => static function (ContainerInterface $c): EntityManagerInterface {
        $config = $c->get(ConfigInterface::class);
        $cacheDriver = $c->get(CacheItemPoolInterface::class);

        $emConfig = new Configuration();
        $emConfig->setAutoGenerateProxyClasses((bool) $config->get('debug.enabled'));
        $emConfig->setMetadataCache($cacheDriver);
        $emConfig->setQueryCache($cacheDriver);
        $driverImpl = $emConfig->newDefaultAnnotationDriver(__DIR__.'/../Orm/Entity/');
        $emConfig->setMetadataDriverImpl($driverImpl);
        $emConfig->setProxyDir(__DIR__.'/../Orm/Proxy/');
        $emConfig->setProxyNamespace($config->get('db.proxy_namespace'));

        $manager = EntityManager::create(
            [
                'driver'   => 'pdo_mysql',
                'user'     => $config->get('db.user'),
                'password' => $config->get('db.pass'),
                'dbname'   => $config->get('db.name'),
                'host'     => $config->get('db.host'),
                'charset'  => 'utf8',
            ],
            $emConfig
        );

        Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
        Type::addType('uuid_binary', 'Ramsey\Uuid\Doctrine\UuidBinaryType');

        $manager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'integer');
        $manager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('uuid_binary', 'binary');

        return $manager;
    },
    CoreControllerInterface::class => autowire(CoreController::class),
    TemplateInterface::class       => autowire(Template::class),
    /**
     * Doctrine ORM.
     *
     * @url https://www.doctrine-project.org/
     */
    \Core\Orm\Repository\UserRepositoryInterface::class => function (ContainerInterface $c): \Core\Orm\Repository\UserRepositoryInterface {
        return $c->get(EntityManagerInterface::class)->getRepository(\Core\Orm\Entity\User::class);
    },
    \Core\Orm\Repository\PlayerRepositoryInterface::class => function (ContainerInterface $c): \Core\Orm\Repository\PlayerRepositoryInterface {
        return $c->get(EntityManagerInterface::class)->getRepository(\Core\Orm\Entity\Player::class);
    },
];
