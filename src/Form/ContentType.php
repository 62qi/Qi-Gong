<?php

namespace App\Form;

use App\Entity\Hook;
use App\Entity\Content;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'help' => 'Le titre du contenu',
            ])
            ->add('summary', CKEditorType::class, [
                'attr' => ['data-editor' => true],
                'label' => 'Description',
                'config_name' => 'light',
                'help' => 'La description sommaire du contenu',
            ])
            ->add('body', CKEditorType::class, [
                'attr' => ['data-editor' => true],
                'label' => 'Corps du texte',
                'config_name' => 'full',
                'help' => 'Le corps du texte du contenu',
            ])
            ->add('imageFile', VichFileType::class, [
                'label' => 'Image (jpg, jpeg, png)',
                'data_class' => null,
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'help' => 'L\'image du contenu',
            ])
            ->add('createdAt', DateType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
            ])
            ->add('hook', EntityType::class, [
                'class' => Hook::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Emplacement sur la page d\'accueil',
                'required' => false,
                'help' => 'La section sur la page où le contenu apparaîtra,
                uniquement pour la page "Accueil",
                Ne pas cocher si le contenu ne doit pas apparaître sur la page d\'accueil',
            ])
            ->add('position', IntegerType::class, [
                'label' => 'Position dans la section (uniquement pour footer et services)',
                'help' => 'La position dans la section sur la page où le contenu apparaîtra :
                accueil-footer = position 1 ou 2,
                accueil-services = position 1 à 4',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Content::class,
        ]);
    }
}
