<?php

namespace App\Service;

use App\Repository\PageRepository;

class Navigation
{
    private PageRepository $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function getNavigation(): array
    {
        return $this->pageRepository->findBy(['isNavLinkOk' => true]);
    }
}
