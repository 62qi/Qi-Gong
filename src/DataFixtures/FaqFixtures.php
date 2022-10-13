<?php

namespace App\DataFixtures;

use App\Entity\Faq;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class FaqFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faq = new Faq();
        $faq->setSubject('Demande de renseignements');
        $faq->setQuestion('Bonjour, Est-ce que les cours de Qi Gong m\'aideront à être plus zen dans ma vie ?');
        $faq->setAnswer('Bonjour, oui tout à fait les cours que je prodiguent aident
        à se sentir mieux dans votre vie de tous les jours.');
        $faq->setIsPublished(true);
        $manager->persist($faq);
        $manager->flush();

        $faq = new Faq();
        $faq->setSubject('Demande de renseignements');
        $faq->setQuestion('Bonjour, Nous sommes une entreprise de 10 personnes, proposez-vous des cours collectifs ?');
        $faq->setAnswer('Bonjour, oui je peut dispenser des cours collectifs, par
        groupe de 10 personnes maximum.');
        $faq->setIsPublished(true);
        $manager->persist($faq);
        $manager->flush();

        $faq = new Faq();
        $faq->setSubject('Demande de tarifs');
        $faq->setQuestion('Combien coûterait un cours de 30 min à domicile ?');
        $faq->setAnswer('Nous pouvons envisager de pratiquer un forfait à la carte.');
        $faq->setIsPublished(true);
        $manager->persist($faq);
        $manager->flush();

        $faq = new Faq();
        $faq->setSubject('Autres');
        $faq->setQuestion('Vous déplacez vous à domicile ?');
        $faq->setAnswer('Oui je peux vous rendre à domicile, éventuellement le mercredi matin.');
        $faq->setIsPublished(true);
        $manager->persist($faq);
        $manager->flush();

        $faq = new Faq();
        $faq->setSubject('Autres');
        $faq->setQuestion('Vous déplacez vous à domicile ?');
        $faq->setAnswer('Oui je peux vous rendre à domicile, éventuellement le mercredi matin.');
        $faq->setIsPublished(false);
        $manager->persist($faq);
        $manager->flush();
    }
}
