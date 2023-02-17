<?php

declare(strict_types=1);

namespace App\DataFixture;

use App\Entity\ProductStock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductsStockFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $quantityProductsStock = new ProductStock();
        $quantityProductsStock->setName('Колбаса');
        $quantityProductsStock->setQuantity(0);
        $manager->persist($quantityProductsStock);

        $quantityProductsStock = new ProductStock();
        $quantityProductsStock->setName('Пармезан');
        $quantityProductsStock->setQuantity(0);
        $manager->persist($quantityProductsStock);

        $quantityProductsStock = new ProductStock();
        $quantityProductsStock->setName('Левый носок');
        $quantityProductsStock->setQuantity(0);
        $manager->persist($quantityProductsStock);

        $manager->flush();
    }
}