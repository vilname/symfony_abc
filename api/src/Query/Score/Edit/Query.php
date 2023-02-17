<?php

declare(strict_types=1);

namespace App\Query\Score\Edit;

use App\Repository\ProductRepository;

class Query
{
    public function __construct(private readonly ProductRepository $userRepository)
    {
    }

    public function handle(int $id)
    {
        return $this->userRepository->find($id);
    }
}