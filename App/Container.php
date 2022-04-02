<?php

declare(strict_types=1);

use Cache\Adapter\PHPArray\ArrayCachePool;
use Core\Module\Core\CoreController;
use Core\Module\Core\CoreControllerInterface;
use Core\Module\Core\Template;
use Core\Module\Core\TemplateInterface;
use Core\Orm\Entity\Map;
use Core\Orm\Entity\MapField;
use Core\Orm\Entity\News;
use Core\Orm\Entity\Player;
use Core\Orm\Entity\StarSystem;
use Core\Orm\Entity\User;
use Core\Orm\Repository\MapFieldRepositoryInterface;
use Core\Orm\Repository\MapRepositoryInterface;
use Core\Orm\Repository\NewsRepositoryInterface;
use Core\Orm\Repository\PlayerRepositoryInterface;
use Core\Orm\Repository\StarSystemRepositoryInterface;
use Core\Orm\Repository\UserRepositoryInterface;
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
    UserRepositoryInterface::class => function (ContainerInterface $c): UserRepositoryInterface {
        return $c->get(EntityManagerInterface::class)->getRepository(User::class);
    },
    PlayerRepositoryInterface::class => function (ContainerInterface $c): PlayerRepositoryInterface {
        return $c->get(EntityManagerInterface::class)->getRepository(Player::class);
    },
    NewsRepositoryInterface::class => function (ContainerInterface $c): NewsRepositoryInterface {
        return $c->get(EntityManagerInterface::class)->getRepository(News::class);
    },
    MapRepositoryInterface::class => function (ContainerInterface $c): MapRepositoryInterface {
        return $c->get(EntityManagerInterface::class)->getRepository(Map::class);
    },
    MapFieldRepositoryInterface::class => function (ContainerInterface $c): MapFieldRepositoryInterface {
        return $c->get(EntityManagerInterface::class)->getRepository(MapField::class);
    },
    StarSystemRepositoryInterface::class => function (ContainerInterface $c): StarSystemRepositoryInterface {
        return $c->get(EntityManagerInterface::class)->getRepository(StarSystem::class);
    },
];
