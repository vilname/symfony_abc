<?php

declare(strict_types=1);

namespace App\Command\Product;

use App\Interface\CommandInterface;

class ProductCommand implements CommandInterface
{
    public function __construct(private readonly string $date)
    {
    }

    public function getDate(): string
    {
        return $this->date;
    }
}