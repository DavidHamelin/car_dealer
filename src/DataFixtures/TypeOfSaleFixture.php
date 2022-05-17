<?php

namespace App\DataFixtures;

use App\Entity\TypeOfSale;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeOfSaleFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $arraySale = ["Location", "Vente", "Leasing"];
        foreach ($arraySale as $sale) {
            $typeSale = new TypeOfSale();
            $typeSale->setName($sale);
            $manager->persist($typeSale);
        }
        $manager->flush();
    }
}
