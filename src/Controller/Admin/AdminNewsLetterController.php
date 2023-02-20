<?php

namespace App\Controller\Admin;

use App\Entity\NewsLetter;
use Symfony\Component\Uid\Uuid;
use App\Repository\PageRepository;
use App\Repository\ContentRepository;
use App\Repository\NewsLetterRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/newsletter')]
class AdminNewsLetterController extends AbstractController
{
    #[Route('/', name: 'app_admin_newsletter_index', methods: ['GET'])]
    public function index(
        Request $request,
        PaginatorInterface $paginator,
        PageRepository $pageRepository
    ): Response {
        $query = $pageRepository->createQueryBuilder('p')
            ->where('p.type = :type')
            ->setParameter('type', 'news')
            ->getQuery();
            $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 10);
        return $this->render('admin/admin_newsletter/index.html.twig', [
            'pages' => $pageRepository->findBy(['type' => 'news']),
            'pagination' => $pagination,
        ]);
    }

    #[Route('/{id}/send-view', name: 'app_admin_newsletter_send', methods: ['GET', 'POST'])]
    public function sendViewNewsletter(
        PageRepository $pageRepository,
        ContentRepository $contentRepository,
        int $id
    ): Response {
        return $this->render('admin/admin_newsletter/send.html.twig', [
            'contents' => $contentRepository->findBy(['page' => $id]),
            'page' => $pageRepository->findOneBy(['id' => $id]),
        ]);
    }

    #[Route('/{id}/send', name: 'send-newsletter', methods: ['GET', 'POST'])]
    public function sendNewsletter(
        MailerInterface $mailer,
        PageRepository $pageRepository,
        ContentRepository $contentRepository,
        NewsLetterRepository $newsLetter,
        int $id
    ): Response {

            $newsletters = $newsLetter->findAll();
        foreach ($newsletters as $newsletter) {
            $email = (new TemplatedEmail())
            ->from($this->getParameter('mailer_from'))
            ->to($newsletter->getEmail())
            ->subject('Newsletter Bien-être & Qi-Gong !')
            ->htmlTemplate('mailer/newsLetter.html.twig')
            ->context(['contents' => $contentRepository->findBy(['page' => $id]),
                'page' => $pageRepository->findOneBy(['id' => $id]),
                'uuid' => Uuid::v4(),
            ]);
            $mailer->send($email);
        }
            $this->addFlash('success', 'Newsletter envoyée avec succès');
            return $this->redirectToRoute('app_admin_newsletter_index', [], Response::HTTP_SEE_OTHER);
    }
}
