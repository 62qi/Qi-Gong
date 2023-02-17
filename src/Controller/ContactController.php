<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\ContactType;
use App\Repository\MessageRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/contact', name: 'contact_')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'new')]
    public function new(Request $request, MessageRepository $messageRepository, MailerInterface $mailer): Response
    {
        $message = new Message();
        $form = $this->createForm(ContactType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageRepository->add($message, true);

            $email = (new TemplatedEmail())
            ->from($message->getEmail())
            ->to($this->getParameter('mailer_to'))
            ->subject('Contact Bien-être & Qi-Gong !')
            ->htmlTemplate('mailer/contact-email.html.twig')
            ->context(['message' => $message]);

            $mailer->send($email);

            $this->addFlash('success', 'Merci votre message a bien été envoyé');
            return $this->redirectToRoute('app_home');
        } else {
            $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi du message');
        }
        return $this->redirectToRoute('app_home');
    }

    public function contactView(): Response
    {
        $message = new Message();
        $form = $this->createForm(ContactType::class, $message, [
            'attr' => ['action' => $this->generateUrl('contact_new')]
        ]);
        return $this->renderForm('contact/_contactForm.html.twig', [
            'form' => $form,
        ]);
    }
}
