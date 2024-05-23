<?php

namespace App\DataFixtures;

use App\Factory\PlanDeTravailFactory;
use App\Factory\SuiviFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SuiviFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        SuiviFactory::createMany(10);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            PlanDeTravailFixtures::class,
        ];
    }
}
