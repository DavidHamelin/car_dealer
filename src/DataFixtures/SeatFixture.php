<?php

namespace App\DataFixtures;

use App\Entity\Seat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SeatFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $arraySeat = [2, 3, 4, 5, 6];
        foreach ($arraySeat as $seat) {
            $place = new Seat();
            $place->setQuantity($seat);
            $manager->persist($place);
        }

        $manager->flush();
    }
}
