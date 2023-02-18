<?php

declare(strict_types=1);

namespace App\Command\Product;

use App\Interface\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

class ProductCommand implements CommandInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private string $date;

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}