<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductStock;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ProductStockRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(ProductStock::class));
    }
}