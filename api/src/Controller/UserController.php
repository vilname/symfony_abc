<?php

declare(strict_types=1);

namespace App\Controller;

use App\Command\User\Command;
use App\Command\User\Handle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(private readonly Handle $handle)
    {
    }

    #[Route(path: '/api/v1/user/save', methods: ['POST'])]
    public function save(Request $request): JsonResponse
    {
        $this->handle->handle(new Command(json_decode($request->getContent(), true)));

        return new JsonResponse(['success' => true]);
    }
}