<?php

declare(strict_types=1);

namespace App\Command\Product;

use App\Interface\CommandInterface;
use App\Interface\HandleInterface;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use App\Service\ProductStockService;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;
use Exception;

class ProductHandle implements HandleInterface
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductService $productService,
        private readonly ProductStockService $productStockService,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param ProductCommand $command
     * @throws Exception
     */
    public function handle(CommandInterface $command): ProductResult
    {
        try {
            $products = $this->productRepository->getByDate($command->getDate());

            $products = $this->productService->getLeftoversInStock($products, $command->getDate());
            $products = $this->productService->updatePrice($products);

            $productsStore = $this->productStockService->calculateQuantityProductInStock($products);

//            foreach ($quantityProductsInStore as $quantityProductInStore) {
//                $this->entityManager->persist($quantityProductInStork);
//            }
//
            // не сохраняю в таблицу `products_stock` общее количество товара на дату, так как это перезапишеть
            // количетство товара в таблице `products`
//            $this->entityManager->flush();

            return new ProductResult($products, $productsStore);
        } catch (Throwable $e) {
            throw new Exception($e->getMessage());
        }

    }
}