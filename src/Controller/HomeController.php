<?php

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PageRepository $pageRepository): Response
    {
        $page = $pageRepository->findOneBySlug('accueil');
        return $this->render('pages/home.html.twig', [
            'page' => $page,
        ]);
    }
}
