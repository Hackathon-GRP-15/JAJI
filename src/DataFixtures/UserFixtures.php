<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // pwd = Test1234
        $pwd = '$2y$13$0fWxLbIeHztLelSkgXLLAONeAD3e7MzH5ntmw4bJYtBQEsRinTNIO';

        $object = (new User())
            ->setEmail('admin@user.fr')
            ->setUsername('admin')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($pwd);

        $manager->persist($object);

        $object = (new User())
            ->setEmail('user@user.fr')
            ->setUsername('user')
            ->setRoles([])
            ->setPassword($pwd);

        $manager->persist($object);


        for ($i = 0; $i < 50; $i++) {
            $object = (new User())
                ->setEmail('user' . $i . '@user.fr')
                ->setUsername($faker->userName)
                ->setRoles([])
                ->setPassword($pwd);
            $manager->persist($object);

            $this->addReference('user_' . $i, $object);
        }

        $manager->flush();
    }
}
