<?php

namespace App\DataFixtures;

use App\Factory\AssignationGroupeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AssignationGroupeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        AssignationGroupeFactory::createMany(6);

        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [
            UserFixtures::class,
            GroupeFixtures::class,
        ];
    }
}
