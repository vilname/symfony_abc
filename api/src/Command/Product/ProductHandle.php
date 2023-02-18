<?php

declare(strict_types=1);

namespace App\Command\Product;

use App\Common\ErrorResult;
use App\Exception\InvalidDateException;
use App\Exception\WrongDateException;
use App\Interface\CommandInterface;
use App\Interface\HandleInterface;
use App\Interface\ResultInterface;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use App\Service\ProductStockService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductHandle implements HandleInterface
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductService $productService,
        private readonly ProductStockService $productStockService,
        private readonly ValidatorInterface $validator,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param ProductCommand $command
     * @throws Exception
     */
    public function handle(CommandInterface $command): ResultInterface
    {
        try {
            $validFormDate = $this->validator->validate($command);
            if ($validFormDate->count() > 0) {
                /** @var ConstraintViolation $error */
                $error = $validFormDate[0];
                throw new InvalidDateException($error->getMessage());
            }

            if ($this->productService->isWrongDate($command->getDate())) {
                throw new WrongDateException();
            }

            $products = $this->productRepository->getByDate($command->getDate());

            $products = $this->productService->getLeftoversInStock($products, $command->getDate());
            $products = $this->productService->updatePrice($products);

            $productsStore = $this->productStockService->calculateQuantityProductInStock($products);

            // не сохраняю в таблицу `products_stock` общее количество товара на дату, так как это перезапишеть
            // количетство товара в таблице `products`
//            foreach ($quantityProductsInStore as $quantityProductInStore) {
//                $this->entityManager->persist($quantityProductInStork);
//            }
//
//            $this->entityManager->flush();

            return new ProductResult($products, $productsStore);
        } catch (Exception $exception) {
            return new ErrorResult($exception->getMessage(), $exception->getCode());
        }
    }
}