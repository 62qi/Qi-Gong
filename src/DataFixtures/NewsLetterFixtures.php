<?php

namespace App\DataFixtures;

use App\Entity\NewsLetter;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Uid\Uuid;

class NewsLetterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $newsletter = new NewsLetter();
        $newsletter->setEmail('email@email.fr');
        $uuid = Uuid::v4();
        $newsletter->setUuid($uuid);
        $manager->persist($newsletter);
        $manager->flush();
    }
}
