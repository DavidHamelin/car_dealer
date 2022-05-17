<?php

namespace App\DataFixtures;

use App\Entity\EnergyOption;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EnergyOptionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $arrayEnergy = ["Sans Plomb 95", "Sans Plomb 98", "Sans Plomb 95 E10", "Diesel", "Electricité"];
        foreach ($arrayEnergy as $energy) {
            $energyOpt = new EnergyOption();
            $energyOpt->setName($energy);
            $manager->persist($energyOpt);
        }
        $manager->flush();
    }
}
