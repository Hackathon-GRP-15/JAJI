<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Content;
use App\Entity\ContentType;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ContentTypeFixtures;
use App\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ContentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $contentTypes = $manager->getRepository(ContentType::class)->findAll();

        for ($i = 0; $i < 20; $i++) {
            $content = new Content();
            $content->setName($faker->word);
            $content->setDescription($faker->text(200));
            $content->setContentType($contentTypes[array_rand($contentTypes)]);
            $manager->persist($content);

            $this->addReference('content_' . $i, $content);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ContentTypeFixtures::class,
        ];
    }
}
