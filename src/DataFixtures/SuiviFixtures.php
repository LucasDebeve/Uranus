<?php

namespace App\DataFixtures;

use App\Factory\SuiviFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SuiviFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        SuiviFactory::createMany(30);

        $manager->flush();
    }
}
