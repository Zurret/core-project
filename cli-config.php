<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__.'/App/Bootstrap.php';

return ConsoleRunner::createHelperSet(
    $app->getContainer()->get(EntityManagerInterface::class)
);
