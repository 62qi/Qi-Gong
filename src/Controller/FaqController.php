<?php

namespace App\Controller;

use App\Repository\FaqRepository;
use App\Repository\PageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FaqController extends AbstractController
{
    #[Route('/faq', name: 'app_faq')]
    public function index(FaqRepository $faqRepository, PageRepository $pageRepository): Response
    {
        $page = $pageRepository->findOneBy(['slug' => 'faq']);
        $faqs = $faqRepository->findBy(['isPublished' => true]);
        return $this->render('pages/questions.html.twig', [
            'faqs' => $faqs,
            'page' => $page
        ]);
    }
}
