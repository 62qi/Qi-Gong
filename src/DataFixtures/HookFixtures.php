<?php

namespace App\DataFixtures;

use App\Entity\Hook;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class HookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $hook = new Hook();
        $hook->setName('accueil-services');
        $this->addReference('accueil-services', $hook);
        $manager->persist($hook);
        $manager->flush();

        $hook = new Hook();
        $hook->setName('accueil-actus');
        $this->addReference('accueil-actus', $hook);
        $manager->persist($hook);
        $manager->flush();

        $hook = new Hook();
        $hook->setName('accueil-presentation');
        $this->addReference('accueil-presentation', $hook);
        $manager->persist($hook);
        $manager->flush();

        $hook = new Hook();
        $hook->setName('accueil-footer');
        $this->addReference('accueil-footer', $hook);
        $manager->persist($hook);
        $manager->flush();

        $hook = new Hook();
        $hook->setName('accueil-partner');
        $this->addReference('accueil-partner', $hook);
        $manager->persist($hook);
        $manager->flush();
    }
}
