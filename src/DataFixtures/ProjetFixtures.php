<?php

namespace App\DataFixtures;

use App\Factory\ProjetFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjetFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ProjetFactory::createMany(11);

        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [
            SequenceFixtures::class,
        ];
    }
}
