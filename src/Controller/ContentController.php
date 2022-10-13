<?php

namespace App\Controller;

use App\Repository\ContentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/content', name: 'content_')]
class ContentController extends AbstractController
{
    public function __construct(private ContentRepository $contentRepository)
    {
    }

    public function getContentsByHook(string $hookName): Response
    {
        $contents = $this->contentRepository->findByHookName($hookName);
        return $this->render('hooks/' . $hookName . '.html.twig', [
            'contents' => $contents
        ]);
    }
}
