<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use App\Entity\User;
use App\DataFixtures\TagFixtures;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TagUserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = $manager->getRepository(User::class)->findOneBy(['email' => 'user@user.fr']);
        $tags = $manager->getRepository(Tag::class)->findAll();

        for($i = 0; $i < 10; $i++) {
            $user->addTag($tags[array_rand($tags)]);
        }

        $manager->persist($user);

        for ($i=0; $i < 20; $i++) { 
            $user = $this->getReference('user_' . $i);
            for ($j=0; $j < 5; $j++) { 
                $user->addTag($this->getReference('tag_' . rand(0, 29)));
            }
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TagFixtures::class,
            UserFixtures::class,
        ];
    }
}
