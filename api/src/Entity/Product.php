<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JsonSerializable;
use DateTime;

#[ORM\Table(name: '`products`')]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'string')]
    private string $deliveryNumber;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'integer')]
    private int $quantity;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'integer')]
    private int $price;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'date')]
    private DateTime $date;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(targetEntity: ProductStock::class, inversedBy: 'products')]
    private ProductStock $productStork;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDeliveryNumber(): string
    {
        return $this->deliveryNumber;
    }

    public function setDeliveryNumber(string $deliveryNumber): void
    {
        $this->deliveryNumber = $deliveryNumber;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    public function getProductStork(): ProductStock
    {
        return $this->productStork;
    }

    public function setProductStork(ProductStock $productStork): void
    {
        $this->productStork = $productStork;
    }


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getProductStork()->getName(),
            'price' => $this->price,
            'quantity' => $this->quantity,
            'date' => $this->date->format('Y-m-d')
        ];
    }
}