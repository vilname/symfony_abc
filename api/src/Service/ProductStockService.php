<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use App\Entity\ProductStock;

class ProductStockService
{
    /**
     * @param Product[] $products
     * @return Product[]
     */
    public function calculateQuantityProductInStock(array $products): array
    {
        $productsStock = [];

        foreach ($products as $product) {
            $storeId = $product->getProductStork()->getId();

            if (!isset($productsStock[$storeId])) {
                $productsStock[$storeId] = $product->getProductStork();
                $productsStock[$storeId]->setQuantity($product->getQuantity());
            } else {
                /** @var ProductStock[] $productsStock */

                $productsStock[$storeId]->setQuantity($productsStock[$storeId]->getQuantity() + $product->getQuantity());
            }
        }

        return $productsStock;
    }
}