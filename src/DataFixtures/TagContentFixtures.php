<?php

namespace App\DataFixtures;

use App\DataFixtures\TagFixtures;
use App\DataFixtures\ContentFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TagContentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 20; $i++) { 
            $content = $this->getReference('content_' . $i);
            $content->addTag($this->getReference('tag_' . rand(0, 29)));
            $manager->persist($content);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ContentFixtures::class,
            TagFixtures::class,
        ];
    }
}
