<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'username' => 'admin',
            'roles' => ['ROLE_ADMIN'],
            'password' => 'admin',
        ]);

        UserFactory::createOne([
            'username' => 'user',
        ]);

        UserFactory::createMany(3);

        $manager->flush();
    }
}
