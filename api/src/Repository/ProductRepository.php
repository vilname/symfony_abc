<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class ProductRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Product::class));
    }

    /**
     * @return Product[]
     */
    public function getByDate(string $date): array
    {
        return $this->createQueryBuilder('products')
            ->where('products.date <= :date')
            ->orderBy('products.date', 'ASC')
            ->setParameter(':date', $date)
            ->getQuery()
            ->getResult();
    }
}
