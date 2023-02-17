<?php

declare(strict_types=1);

namespace App\Command\User;

use App\Entity\Product;
use App\Exception\IncorrectEducationTypeException;
use App\Exception\IncorrectUserIdException;
use App\Exception\NotFoundUserException;
use App\Interface\CommandInterface;
use App\Interface\HandleInterface;
use App\Repository\ProductStockRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;
use Exception;

class Handle implements HandleInterface
{
    public function __construct(
        private readonly ProductRepository $userRepository,
        private readonly ValidatorInterface $validator,
        private readonly ProductStockRepository$educationTypeRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param Command $command
     * @return void
     * @throws \Exception
     */
    public function handle(CommandInterface $command)
    {
        try {
            if (empty($command->id)) {
                throw new IncorrectUserIdException();
            }

            if (empty($command->educationType)) {
                throw new IncorrectEducationTypeException();
            }

            $educationType = $this->educationTypeRepository->findOneBy(['type' => $command->educationType]);

            if (empty($educationType)) {
                throw new IncorrectEducationTypeException();
            }

            /** @var Product $user */
            $user = $this->userRepository->find($command->id);
            if (is_null($user)) {
                throw new NotFoundUserException();
            }

            $userUpdate = $user::create(
                $command->firstName,
                $command->lastName,
                $command->phone,
                $command->email,
                $educationType,
                $command->agreement,
            );

            $userUpdate->setId($user->getId());

            $errors = $this->validator->validate($user);

            if (count($errors) > 0) {

            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }
}