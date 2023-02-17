<?php

declare(strict_types=1);

namespace App\Controller;

use App\Command\Score\List\Command;
use App\Command\Score\List\Handle;
use App\Query\Score\Edit\Query;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ScoreController extends AbstractController
{
    public const PAGE_SIZE = 5;

    public function __construct(
        private readonly Handle $handle,
        private readonly Query $query
    ) {
    }

    #[Route(path: '/api/v1/score', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $page = (int)$request->query->get('page');
        $handle = $this->handle->handle(new Command(self::PAGE_SIZE, $page));

        return new JsonResponse($handle);
    }

    #[Route(path: '/api/v1/score/edit/{id}', methods: ['GET'])]
    public function edit(int $id): JsonResponse
    {
        return new JsonResponse($this->query->handle($id));
    }
}