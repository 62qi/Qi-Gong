<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Nom'],
            ])
            ->add('surname', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Prénom'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'Email'],
            ])
            ->add('subject', ChoiceType::class, [
                'label' => 'Sujet',
                'choices' => [
                    'Demande de tarifs' => 'Demande de tarifs',
                    'Demande de renseignements' => 'Demande de renseignements',
                    'Autre' => 'Autre',
                ],
                'attr' => ['placeholder' => 'Sujet'],
            ])
            ->add('content', TextType::class, [
                'label' => 'Message',
                'attr' => ['placeholder' => 'Message'],
            ])
            ->add('isFaqOK', CheckboxType::class, [
                'label' => 'J\'autorise la publication de mon message dans la FAQ',
                'required' => false,
            ])
            ->add('isRead', CheckboxType::class, [
                'label' => 'Message lu',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
