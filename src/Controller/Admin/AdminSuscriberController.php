<?php

namespace App\Controller\Admin;

use App\Repository\NewsLetterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/suscriber')]
class AdminSuscriberController extends AbstractController
{
    #[Route('/', name: 'app_admin_suscriber')]
    public function index(NewsLetterRepository $newsLetterRepository): Response
    {
        return $this->render('admin/admin_suscriber/index.html.twig', [
            'suscribers' => $newsLetterRepository->findAll(),
        ]);
    }
}
