<?php

namespace App\DataFixtures;

use App\Entity\ContentType;
use App\DataFixtures\ContentFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ContentTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $contentType = new ContentType();
        $contentType->setName('Article');
        $manager->persist($contentType);

        $contentType = new ContentType();
        $contentType->setName('Image');
        $manager->persist($contentType);

        $contentType = new ContentType();
        $contentType->setName('Video');
        $manager->persist($contentType);

        $contentType = new ContentType();
        $contentType->setName('Audio');
        $manager->persist($contentType);

        $contentType = new ContentType();
        $contentType->setName('Document');
        $manager->persist($contentType);

        $manager->flush();
    }
}
