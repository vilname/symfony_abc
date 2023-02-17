<?php

declare(strict_types=1);

namespace App\Command\Auth\SignUp;

use App\Entity\Product;
use App\Exception\IncorrectEducationTypeException;
use App\Exception\UserAlreadyExistsException;
use App\Interface\CommandInterface;
use App\Interface\HandleInterface;
use App\Repository\ProductStockRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Handle implements HandleInterface
{
    public function __construct(
        private readonly ProductRepository $userRepository,
        private readonly ProductStockRepository$educationTypeRepository,
        private readonly UserPasswordHasherInterface $hasher,
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
        private readonly AuthenticationSuccessHandler $authenticationSuccessHandler
    ) {}

    /**
     * @param Command $command
     * @return void
     */
    public function handle(CommandInterface $command): Response
    {
        if ($this->userRepository->existsByEmail($command->email)) {
            throw new UserAlreadyExistsException();
        }

        if (empty($command->educationType)) {
            throw new IncorrectEducationTypeException();
        }

        $educationType = $this->educationTypeRepository->findOneBy(['type' => $command->educationType]);

        if (empty($educationType)) {
            throw new IncorrectEducationTypeException();
        }

        $user = Product::create(
            $command->firstName,
            $command->lastName,
            $command->phone,
            $command->email,
            $educationType,
            $command->agreement,
        );

        $hashedPassword = $this->hasher->hashPassword(
            $user,
            $command->password
        );

        $user->setPassword($hashedPassword);

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {

        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->authenticationSuccessHandler->handleAuthenticationSuccess($user);
    }
}