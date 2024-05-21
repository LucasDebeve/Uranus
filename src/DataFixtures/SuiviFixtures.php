<?php

namespace App\DataFixtures;

use App\Factory\SuiviFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SuiviFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        SuiviFactory::createMany(30);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            PlanDeTravailFixtures::class,
        ];
    }
}
