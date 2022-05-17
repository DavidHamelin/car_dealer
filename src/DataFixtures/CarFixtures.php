<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($count = 1; $count <= 5; $count++) {
            $car = new Car();
            // $car->setId($i);
            $car->setBrand("Ferrari ".$count);
            $car->setModel("488 GTB");
            $car->setYear(2015);
            $car->setEngine("V8 bi-turbo");
            $car->setColor("rouge");
            $car->setKm($count."00000");
            $car->setImage("");
            $manager->persist($car);
        }
        $manager->flush();
    }
}
