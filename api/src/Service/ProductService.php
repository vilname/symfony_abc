<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use DateTime;

class ProductService
{
    public const START_SHIPMENT_BY_FIBONACCI_NUMBERS = '2021-01-13';
    public const PRODUCT_SHIPMENT_BY_FIBONACCI_NUMBERS = 'Левый носок';

    /**
     * @param Product[] $products
     * @return Product[]
     */
    public function updatePrice(array $products): array
    {
        foreach ($products as $product) {
            $price = $product->getPrice();

            $product->setPrice((int)($price + ($price * 0.3)));
        }

        return $products;
    }

    /**
     * @param Product[] $products
     * @return Product[]
      */
    public function getLeftoversInStock(array $products, string $currentDate): array
    {
        $daysDiff = $this->getDiffDays($currentDate);

        $sumPreOrders = $this->getSumFibonacciByDays($daysDiff);

        foreach ($products as $product) {
            if ($product->getProductStork()->getName() === self::PRODUCT_SHIPMENT_BY_FIBONACCI_NUMBERS) {
                $quantity = $product->getQuantity();

                if ($quantity >= $sumPreOrders) {
                    $product->setQuantity($quantity - $sumPreOrders);

                    return $products;
                } else {
                    $product->setQuantity(0);
                    $sumPreOrders -= $quantity;
                }
            }
        }

        return $products;
    }

    private function getSumFibonacciByDays(int $countDays, int $first = 0, int $second = 1): int
    {
        $fib = [$first, $second];
        for ($i = 1; $i < $countDays; $i++) {
            $fib[] = $fib[$i] + $fib[$i - 1];
        }
        return array_sum($fib);
    }

    private function getDiffDays(string $currentDate): int
    {
        $dateStartFibonacci = new DateTime(self::START_SHIPMENT_BY_FIBONACCI_NUMBERS);
        $currentDate = new DateTime($currentDate);
        $diff = $currentDate->diff($dateStartFibonacci);
        return (int)$diff->format("%a");
    }
}
