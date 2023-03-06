<?php

namespace App\DataFixtures;

use Faker\Factory;
use DateTimeImmutable;
use App\Entity\Content;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ContentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 30; $i++) {
            $content = new Content();
            $content->setBody($faker->realText(200));
            $content->setSummary($faker->realText(100));
            $content->setImage('cat.jpg');
            $content->setTitle($faker->sentence(3));
            $content->setCreatedAt(new DateTimeImmutable());
            $content->setPosition(rand(1, 4));
            $content->setPage($this->getReference(
                ['home-page', 'services-page', 'bio-page','news-page', 'legals-page', 'questions-page', 'story-page'][rand(0, 5)]
            ));
            $content->addHook($this->getReference(
                ['accueil-services', 'accueil-partner', 'accueil-actus', 'accueil-footer', 'accueil-presentation']
                [rand(0, 4)]
            ));
            $manager->persist($content);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            PageFixtures::class,
            HookFixtures::class,
        ];
    }
}
