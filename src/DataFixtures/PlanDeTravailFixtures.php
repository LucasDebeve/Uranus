<?php

namespace App\DataFixtures;

use App\Factory\PlanDeTravailFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlanDeTravailFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        PlanDeTravailFactory::createMany(10);

        $manager->flush();
    }
}
