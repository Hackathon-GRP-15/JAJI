<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i < 30; $i++) { 
            $tag = new Tag();
            $tag->setName($faker->word);
            $manager->persist($tag);

            $this->addReference('tag_' . $i, $tag);
        }

        $manager->flush();
    }
}
