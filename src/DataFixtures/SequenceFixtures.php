<?php

namespace App\DataFixtures;

use App\Factory\SequenceFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SequenceFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $data = file_get_contents(__DIR__.'/data/sequences.json');
        $sequences = json_decode($data, true);

        foreach ($sequences as $sequence) {
            // Convert dateDeb and dateFin to DateTime
            $sequence['dateDeb'] = new \DateTime($sequence['dateDeb']);
            $sequence['dateFin'] = new \DateTime($sequence['dateFin']);
            SequenceFactory::createOne($sequence);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PlanDeTravailFixtures::class,
        ];
    }
}
