<?php

declare(strict_types=1);

namespace App\Command\Product;

use App\Entity\Product;
use App\Entity\ProductStock;
use App\Interface\ResultInterface;

class ProductResult implements ResultInterface
{
    /**
     * @var Product[]
     */
    public array $products;

    /**
     * @var ProductStock[]
     */
    public array $productsStock;

    public function __construct(array $products, array $productsStock)
    {
        $this->products = $products;
        $this->productsStock = $productsStock;
    }
}
