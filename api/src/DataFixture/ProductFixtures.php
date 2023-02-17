<?php

declare(strict_types=1);

namespace App\DataFixture;

use App\Entity\ProductStock;
use App\Entity\Product;
use App\Repository\ProductStockRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly ProductStockRepository $quantityProductStockRepository)
    {
    }
    public function load(ObjectManager $manager)
    {
        $quantityProductsStock = $this->quantityProductStockRepository->findAll();
        $products = $this->getProducts();

        foreach ($products as $product) {
            $productEntity = new Product();
            $productEntity->setDeliveryNumber($product['delivery_number']);
            $productEntity->setQuantity($product['quantity']);
            $productEntity->setPrice($product['price']);
            $productEntity->setDate(new DateTime($product['date']));

            /** @var ProductStock $quantityProductStock */
            foreach ($quantityProductsStock as $quantityProductStock) {
                if ($product['name'] === $quantityProductStock->getName()) {
                    $productEntity->setProductStork($quantityProductStock);
                }
            }

            $manager->persist($productEntity);
        }

        $manager->flush();
    }

    private function getProducts(): array
    {
        return [
            [
                'delivery_number' => '1',
                'name' => 'Колбаса',
                'quantity' => 300,
                'price' => 5000,
                'date' => '2021-01-01',
            ],
            [
                'delivery_number' => 't-500',
                'name' => 'Пармезан',
                'quantity' => 10,
                'price' => 6000,
                'date' => '2021-01-02',
            ],
            [
                'delivery_number' => '12-TP-777',
                'name' => 'Левый носок',
                'quantity' => 100,
                'price' => 500,
                'date' => '2021-01-13',
            ],
            [
                'delivery_number' => '12-TP-778',
                'name' => 'Левый носок',
                'quantity' => 50,
                'price' => 300,
                'date' => '2021-01-14',
            ],
            [
                'delivery_number' => '12-TP-779',
                'name' => 'Левый носок',
                'quantity' => 77,
                'price' => 539,
                'date' => '2021-01-20',
            ],
            [
                'delivery_number' => '12-TP-877',
                'name' => 'Левый носок',
                'quantity' => 32,
                'price' => 176,
                'date' => '2021-01-30',
            ],
            [
                'delivery_number' => '12-TP-977',
                'name' => 'Левый носок',
                'quantity' => 94,
                'price' => 554,
                'date' => '2021-02-01',
            ],
            [
                'delivery_number' => '12-TP-979',
                'name' => 'Левый носок',
                'quantity' => 200,
                'price' => 1000,
                'date' => '2021-02-05',
            ],
        ];
    }

//    private function getEducationTypes(): array
//    {
//        $educationTypes = $this->educationTypeRepository->findAll();
//        $associatedEducationTypes = [];
//
//        /** @var QuantityProductsStock $educationType */
//        foreach ($educationTypes as $educationType) {
//            $associatedEducationTypes[$educationType->getType()] = $educationType;
//        }
//
//        return $associatedEducationTypes;
//    }

    public function getDependencies()
    {
        return [
            ProductsStockFixtures::class
        ];
    }
}