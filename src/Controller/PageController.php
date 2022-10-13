<?php

namespace App\Controller;

use App\Entity\Page;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    #[Route('/{slug}', name: 'page', priority: -1)]
    public function show(Page $page): Response
    {
        return $this->render('pages/' . $page->getTemplate() . '.html.twig', [
            'page' => $page,
        ]);
    }
}
