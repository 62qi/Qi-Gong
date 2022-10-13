<?php

namespace App\DataFixtures;

use App\Entity\Page;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $page = new Page();
        $page->setTitle('Acceuil Qigong');
        $page->setDescription('test description');
        $page->setSlug('accueil');
        $page->setLinkNameNav('Accueil');
        $page->setIsNavLinkOk(true);
        $page->setTitleH1('Bienvenue sur Qigong');
        $page->setType('Home type');
        $page->setTemplate('home');
        $page->setColor('#353535');
        $this->addReference('home-page', $page);
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Mes Services');
        $page->setDescription('test services');
        $page->setSlug('services');
        $page->setLinkNameNav('Mes Services');
        $page->setIsNavLinkOk(true);
        $page->setTitleH1('Mes Services');
        $page->setType('Service type');
        $page->setTemplate('services');
        $page->setColor('#385F71');
        $this->addReference('services-page', $page);
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Actualités');
        $page->setDescription('test acutalites');
        $page->setSlug('actualites');
        $page->setLinkNameNav('Actualités');
        $page->setIsNavLinkOk(true);
        $page->setTitleH1('Toutes les actualités');
        $page->setType('Actu type');
        $page->setTemplate('news');
        $page->setColor('#629A69');
        $this->addReference('news-page', $page);
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Mentions Légales');
        $page->setDescription('test legals');
        $page->setSlug('mentions-legales');
        $page->setLinkNameNav('Mentions Légales');
        $page->setIsNavLinkOk(false);
        $page->setTitleH1('Mentions Légales');
        $page->setType('Legal type');
        $page->setTemplate('legals');
        $page->setColor('#BEBB2F');
        $this->addReference('legals-page', $page);
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Vos Questions');
        $page->setDescription('test questions');
        $page->setSlug('faq');
        $page->setLinkNameNav('Vos Questions');
        $page->setIsNavLinkOk(true);
        $page->setTitleH1('Foires aux Questions');
        $page->setType('Question type');
        $page->setTemplate('questions');
        $page->setColor('#CCC4B4');
        $this->addReference('questions-page', $page);
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Mon parcours');
        $page->setDescription('test bio');
        $page->setSlug('bio');
        $page->setLinkNameNav('Mon parcours');
        $page->setIsNavLinkOk(true);
        $page->setTitleH1('Mon Parcours');
        $page->setType('Bio type');
        $page->setTemplate('bio');
        $page->setColor('#F64D4D');
        $this->addReference('bio-page', $page);
        $manager->persist($page);
        $manager->flush();
    }
}
