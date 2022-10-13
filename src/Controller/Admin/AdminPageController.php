<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use App\Form\PageType;
use App\Entity\Content;
use App\Repository\PageRepository;
use App\Repository\ContentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/page')]
class AdminPageController extends AbstractController
{
    #[Route('/', name: 'app_admin_page_index', methods: ['GET'])]
    public function index(
        PageRepository $pageRepository,
        ContentRepository $contentRepository,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
            $query = $pageRepository->createQueryBuilder('p')
                ->orderBy('p.type', 'DESC')
                ->where('p.type != :type')
                ->setParameter('type', 'news')
                ->getQuery();
            $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 10);
        return $this->render('admin/admin_page/index.html.twig', [
            'pages' => $pageRepository->findAll(),
            'contents' => $contentRepository->findAll(),
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_admin_page_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PageRepository $pageRepository): Response
    {
        $page = new Page();
        $content  = new Content();
        $page->addContent($content);
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pageRepository->add($page, true);

            if ($page->getType() === 'news') {
                return $this->redirectToRoute('app_admin_newsletter_index', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('app_admin_page_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('admin/admin_page/new.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_page_show', methods: ['GET'])]
    public function show(Page $page): Response
    {
        return $this->render('admin/admin_page/show.html.twig', [
            'page' => $page,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_page_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Page $page,
        PageRepository $pageRepository,
        ContentRepository $contentRepository
    ): Response {
        $form = $this->createForm(PageType::class, $page);
        $contents = new ArrayCollection();

        foreach ($page->getContents() as $tag) {
            $contents->add($tag);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($contents as $content) {
                if (false === $page->getContents()->contains($content)) {
                    $contentRepository->remove($content, true);
                }
            }
            $pageRepository->add($page, true);

            if ($page->getType() === 'news') {
                return $this->redirectToRoute('app_admin_newsletter_index', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('app_admin_page_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('admin/admin_page/edit.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_page_delete', methods: ['POST'])]
    public function delete(Request $request, Page $page, PageRepository $pageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $page->getId(), $request->request->get('_token'))) {
            $pageRepository->remove($page, true);
        }

        if ($page->getType() === 'news') {
            return $this->redirectToRoute('app_admin_newsletter_index', [], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_admin_page_index', [], Response::HTTP_SEE_OTHER);
        }
    }
}
