<?php

declare(strict_types=1);

namespace Core\Module\Website\View;

use Core\Module\Core\CoreControllerInterface;
use Core\Orm\Repository\NewsRepositoryInterface;

class ShowIndexPage
{
    private CoreControllerInterface $core;

    private NewsRepositoryInterface $news;

    public function __construct(
        CoreControllerInterface $core,
        NewsRepositoryInterface $news
    ) {
        $this->core = $core;
        $this->news = $news;
    }

    /**
     * @route GET /
     */
    public function __invoke(): void
    {
        $this->core->setTemplateTitle('Startseite');
        $this->core->setTemplateVar('news_list', $this->news->getRecent());
        $this->core->render('Index/showHomePage');
    }
}
