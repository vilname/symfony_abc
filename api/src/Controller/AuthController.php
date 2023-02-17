<?php

declare(strict_types=1);

namespace App\Controller;

use App\Command\Auth\SignUp\Command;
use App\Command\Auth\SignUp\Handle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    public function __construct(private Handle $handle)
    {
    }

    #[Route(path: '/api/v1/auth/signUp', methods: ['POST'])]
    public function signUp(Request $request): Response
    {
        return $this->handle->handle(new Command(json_decode($request->getContent(), true)));
    }
}