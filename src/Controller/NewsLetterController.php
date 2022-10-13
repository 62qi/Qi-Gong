<?php

namespace App\Controller;

use App\Form\NewsType;
use App\Entity\NewsLetter;
use App\Repository\NewsLetterRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Uid\Uuid;

class NewsLetterController extends AbstractController
{
    #[Route('/subscribe-newsletter', name: 'app_newsletter')]
    public function new(
        Request $request,
        NewsLetterRepository $newsLetterRepository,
        MailerInterface $mailer
    ): Response {

        $newsLetter = new NewsLetter();
        $form = $this->createForm(NewsType::class, $newsLetter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uuid = Uuid::v4();
            $newsLetter->setUuid($uuid);
            $newsLetterRepository->add($newsLetter, true);

            $email = (new TemplatedEmail())
            ->from($this->getParameter('mailer_from'))
            ->to($newsLetter->getEmail())
            ->subject('Insciption Newsletter Bien-être & Qi-Gong !')
            ->htmlTemplate('mailer/sub-email.html.twig')
            ->context(['uuid' => $uuid]);

            $mailer->send($email);

            $this->addFlash('success', 'Votre adresse e-mail a  bien été enregistrée, merci !');
            return $this->redirectToRoute('app_home');
        }
        return $this->redirectToRoute(route: 'app_home');
    }

    #[Route('/unsubscribe/{uuid}', name: 'unsubscribe')]
    public function unsubscribeNewsletter(NewsLetter $newsLetter, string $uuid): Response
    {
        return $this->render('mailer/unsubscribe-form.html.twig', [
            'newsLetter' => $newsLetter,
            'uuid' => $uuid
        ]);
    }

    #[Route('/validate-unsubscribe/{uuid}', name: 'validate-unsubscribe')]
    public function validateUnsubscribe(
        Request $request,
        NewsLetter $newsLetter,
        NewsLetterRepository $newsLetterRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $newsLetter->getId(), $request->request->get('_token'))) {
            $newsLetterRepository->remove($newsLetter, true);
            $this->addFlash('success', 'Votre adresse e-mail a bien été supprimée, merci !');
        }
        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }

    public function subscribeForm(): Response
    {
        $newsLetter = new NewsLetter();
        $form = $this->createForm(NewsType::class, $newsLetter, [
            'attr' => ['action' => $this->generateUrl('app_newsletter')]
        ]);
        return $this->renderForm('include/_newsletter.html.twig', [
            'form' => $form,
        ]);
    }
}
