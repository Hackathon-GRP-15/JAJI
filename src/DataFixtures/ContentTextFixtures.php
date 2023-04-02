<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Content;
use App\Entity\ContentText;
use App\DataFixtures\ContentFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use function PHPSTORM_META\type;

class ContentTextFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i < 20; $i++) { 
            $contentText = new ContentText();
            $contentText->setContent($this->getReference('content_' . $i));
            $contentText->setText($faker->text(1000));
            $manager->persist($contentText);
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
