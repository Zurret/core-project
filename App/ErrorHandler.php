<?php

    declare(strict_types=1);

    use Whoops\Handler\PrettyPageHandler;
    use Whoops\Run;

    $whoops = new Run();
    $errorPage = new PrettyPageHandler();

        $errorPage->setPageTitle("It's broken!");
        $errorPage->setEditor('vscode');

        $whoops->pushHandler($errorPage);
        $whoops->register();
