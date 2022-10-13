<?php

namespace App\Controller\Admin;

use App\Entity\Faq;
use App\Form\FaqType;
use App\Entity\Message;
use App\Repository\FaqRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/faq')]
class AdminFaqController extends AbstractController
{
    #[Route('/', name: 'app_admin_faq_index', methods: ['GET'])]
    public function index(
        FaqRepository $faqRepository,
        MessageRepository $messageRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $query = $faqRepository->createQueryBuilder('f')
            ->getQuery();
            $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 10);
        return $this->render('admin/admin_faq/index.html.twig', [
            'faqs' => $faqRepository->findAll(),
            'messages' => $messageRepository->findAll(),
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_admin_faq_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FaqRepository $faqRepository): Response
    {
        $faq = new Faq();
        $form = $this->createForm(FaqType::class, $faq);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $faqRepository->add($faq, true);

            return $this->redirectToRoute('app_admin_faq_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_faq/new.html.twig', [
            'faq' => $faq,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/new-faq-from-message', name:'app_admin_faq_new_from_message')]
    public function newFromMessage(Message $message, EntityManagerInterface $entityManager): Response
    {
        $faq = new Faq();
        $faq->setQuestion($message->getContent());
        $faq->setIsPublished(false);
        $entityManager->persist($faq);
        // $message->setIsFaqOk(false);
        $message->setFaq($faq);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin_faq_index');
    }

    #[Route('/{id}', name: 'app_admin_faq_show', methods: ['GET'])]
    public function show(Faq $faq): Response
    {
        return $this->render('admin/admin_faq/show.html.twig', [
            'faq' => $faq,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_faq_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Faq $faq, FaqRepository $faqRepository): Response
    {
        $form = $this->createForm(FaqType::class, $faq);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $faqRepository->add($faq, true);

            return $this->redirectToRoute('app_admin_faq_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_faq/edit.html.twig', [
            'faq' => $faq,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_faq_delete', methods: ['POST'])]
    public function delete(Request $request, Faq $faq, FaqRepository $faqRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $faq->getId(), $request->request->get('_token'))) {
            $faqRepository->remove($faq, true);
        }

        return $this->redirectToRoute('app_admin_faq_index', [], Response::HTTP_SEE_OTHER);
    }
}
