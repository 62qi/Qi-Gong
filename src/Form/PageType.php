<?php

namespace App\Form;

use App\Entity\Page;
use App\Form\ContentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'help' => 'Ce titre est utilisé pour le référencement de la page',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'help' => 'Cette description est utilisée pour le référencement de la page,
                elle est limitée à 150 caractères',
            ])
            ->add('slug', TextType::class, [
                'label' => 'Nom de la page',
                'help' => 'Ce nom est utilisé pour le nom dans la barre de navigation',
            ])
            ->add('LinkNameNav', TextType::class, [
                'label' => 'Nom du lien dans le menu',
                'required' => false,
                'help' => 'Ce nom est utilisé pour le nom du lien dans le menu',
            ])
            ->add('isNavLinkOk', CheckBoxType::class, [
                'label' => 'Afficher le lien dans le menu',
                'required' => false,
                'help' => 'Cochez cette case pour afficher le lien dans le menu',
            ])
            ->add('titleH1', TextType::class, [
                'label' => 'Titre de la page',
                'help' => 'Ce titre est utilisé pour le titre de la page',
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'type de contenu',
                'choices' => [
                    'Actualités' => 'news',
                    'Page' => 'page',
                ],
                'help' => 'Contenu de la page',
            ])
            ->add('template', ChoiceType::class, [
                'label' => 'template',
                'choices' => [
                    'Actualités' => 'news',
                    'Accueil' => 'home',
                    'Services' => 'services',
                    'Mentions Légales' => 'legals',
                    'FAQ' => 'questions',
                    'Biographie' => 'bio',
                    'Classique' => 'classic',
                    'Credits' => 'credits',
                ],
                'help' => 'Gabarit utilisé pour le rendu de la page',
            ])

            ->add('color', ColorType::class, [
                'label' => 'Couleur',
                'help' => '<div class="helper">Couleur de la page, les couleurs du site : <ul>
                <li>couleur noire = R: 33 G: 37 B: 41 </li>
                <li>couleur verte = R: 11 G: 105 B: 47 </li>
                <li>couleur bleue = R: 27 G: 104 B: 187 </li>
                <li>couleur rouge = R: 188 G: 24 B: 24 </li>
                <li>couleur jaune = R: 243 G: 229 B: 43 </li></ul>
                </div>',
                'help_html' => true,
                ])
            ->add('contents', CollectionType::class, [
                'label' => false,
                'entry_type' => ContentType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
