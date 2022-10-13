<?php

namespace App\Controller\Admin;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\FaqRepository;
use App\Repository\MessageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/message')]
class AdminMessageController extends AbstractController
{
    #[Route('/', name: 'app_admin_message_index', methods: ['GET'])]
    public function index(
        MessageRepository $messageRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $query = $messageRepository->createQueryBuilder('m')
            ->orderBy('m.isRead', 'ASC')
            ->getQuery();
        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 10);
        return $this->render('admin/admin_message/index.html.twig', [
            'messages' => $messageRepository->findAll(),
            'pagination' => $pagination,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_message_show', methods: ['GET'])]
    public function show(Message $message): Response
    {
        return $this->render('admin/admin_message/show.html.twig', [
            'message' => $message,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_message_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Message $message, MessageRepository $messageRepository): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageRepository->add($message, true);

            return $this->redirectToRoute('app_admin_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_message/edit.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_message_delete', methods: ['POST'])]
    public function delete(Request $request, Message $message, MessageRepository $messageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $message->getId(), $request->request->get('_token'))) {
            $messageRepository->remove($message, true);
        }

        return $this->redirectToRoute('app_admin_message_index', [], Response::HTTP_SEE_OTHER);
    }
}
