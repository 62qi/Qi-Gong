<?php

namespace App\DataFixtures;

use App\Entity\Message;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class MessageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 30; $i++) {
            $message = new Message();

            $message->setName($faker->name);
            $message->setSurname($faker->lastName);
            $message->setEmail($faker->email);
            $message->setSubject($faker->sentence(3));
            $message->setContent($faker->text(100));
            $message->setIsFaqOK($faker->boolean);
            $message->setIsRead($faker->boolean);
            $message->setCreatedAt($faker->dateTime);
            $manager->persist($message);
            $manager->flush();
        }
    }
}
