<?php

namespace App\DataFixtures;

use App\Entity\Page;
use DateTimeImmutable;
use App\Entity\Content;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class NewsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $news1 = new Page();
        $news1->setTitle('New du 23/06');
        $news1->setDescription('New du 23/06');
        $news1->setSlug('news-du-23-06-2022');
        $news1->setTitleH1('Toutes les actualités du 23/06');
        $news1->setType('news');
        $news1->setTemplate('lorem-ipsum');
        $news1->setColor('#629A69');
        $manager->persist($news1);
        $manager->flush();

        ///////////////////// Fixtures News////////////////////////////
        $content = new Content();
        $content->setBody('test News');
        $content->setSummary('Le citron apporte de nombreux bienfaits pour la santé.Tout d’abord, il est riche...');
        $content->setImage('https://cdn.pixabay.com/photo/2016/11/21/16/40/agriculture-1846358_960_720.jpg');
        $content->setTitle('Les bienfaits du citron');
        $content->setCreatedAt(new DateTimeImmutable());
        $content->setPosition(1);
        $content->setPage($news1);
        //$content->addHook($this->getReference('accueil-actus'));
        $manager->persist($content);
        $manager->flush();

        $news2 = new Page();
        $news2->setTitle('New du 23/06');
        $news2->setDescription('New du 23/06');
        $news2->setSlug('news-du-23-06-2022');
        $news2->setTitleH1('Toutes les actualités du 23/06');
        $news2->setType('news');
        $news2->setTemplate('lorem-ipsum');
        $news2->setColor('#629A69');
        $manager->persist($news2);
        $manager->flush();

        $content = new Content();
        $content->setBody('test News');
        $content->setSummary('La randonnée est un sport qui se déroule en montagne...');
        $content->setImage('https://cdn.pixabay.com/photo/2014/09/21/17/56/mountaineering-455338_960_720.jpg');
        $content->setTitle('La randonnée');
        $content->setCreatedAt(new DateTimeImmutable());
        $content->setPosition(2);
        $content->setPage($news2);
        //$content->addHook($this->getReference('accueil-actus'));
        $manager->persist($content);
        $manager->flush();

        $content = new Content();
        $content->setBody('test News');
        $content->setSummary('Les news');
        $content->setImage('https://cdn.pixabay.com/photo/2019/08/11/07/11/beach-4398269_960_720.jpg');
        $content->setTitle('Les bienfaits des news');
        $content->setCreatedAt(new DateTimeImmutable());
        $content->setPosition(3);
        $content->setPage($news2);
        //$content->addHook($this->getReference('accueil-actus'));
        $manager->persist($content);
        $manager->flush();

        $content = new Content();
        $content->setBody('test News');
        $content->setSummary('Le lacher de poule est un sport qui se déroule en montagne...');
        $content->setImage('https://cdn.pixabay.com/photo/2019/05/01/20/38/acrobat-4171996_960_720.jpg');
        $content->setTitle('Le lacher prise');
        $content->setCreatedAt(new DateTimeImmutable());
        $content->setPosition(4);
        $content->setPage($news2);
        //$content->addHook($this->getReference('accueil-actus'));
        $manager->persist($content);
        $manager->flush();
    }
}
