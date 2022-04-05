<?php

declare(strict_types=1);

namespace Core\App;

use Core\Lib\Ubench;
use DI\Container;
use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Noodlehaus\ConfigInterface;

class App
{
    private Container $container; // DI Container
    private Ubench $benchmark; // Benchmark

    public function run(): void
    {
        try {
            $this->init();
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function getConfig(string $key): mixed
    {
        return $this->getContainer()->get(ConfigInterface::class)->get($key);
    }

    public function getBenchmark(): Ubench
    {
        return $this->benchmark;
    }

    /**
     * @throws Exception
     */
    private function init(): void
    {
        $this->initBenchmark();
        $this->initContainer();
    }

    /**
     * @throws Exception
     */
    private function initContainer(): void
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(__DIR__.'/Container.php');

        $this->container = $builder->build();
    }

    private function initBenchmark(): void
    {
        $bench = new Ubench();
        $bench->start();
        $this->benchmark = $bench;
    }
}
