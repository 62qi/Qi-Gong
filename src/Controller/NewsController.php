<?php

namespace App\Controller;

use App\Repository\PageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsController extends AbstractController
{
    #[Route('/actualites', name: 'app_news')]
    public function index(
        PageRepository $pageRepository,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        $query = $pageRepository->queryFindByType('news');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            1
        );
        $newsPage = $pageRepository->findOneBySlug('actualites');
        return $this->render('news/index.html.twig', [
            'pagination' => $pagination,
            'page' => $newsPage
        ]);
    }
}
