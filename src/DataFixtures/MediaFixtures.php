<?php

namespace App\DataFixtures;

use App\DataFixtures\ContentFixtures;
use App\Entity\Media;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MediaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 20; $i++) { 
            for ($j=0; $j < 3; $j++) { 
                $image = new Media();
                $image->setContent($this->getReference('content_' . $i));
                $image->setFilename('https://picsum.photos/800/800?random=1');
                $image->setType('image');
                $manager->persist($image);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ContentFixtures::class,
        ];
    }
}
