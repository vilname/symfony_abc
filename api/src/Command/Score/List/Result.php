<?php

declare(strict_types=1);

namespace App\Command\Score\List;

use App\Common\ResultPagination;
use App\Interface\ResultInterface;

class Result implements ResultInterface
{
    public array $users;

    public ResultPagination $pagination;

    public function __construct(
        array $users,
        ResultPagination $pagination
    ) {
        $this->users = $users;
        $this->pagination = $pagination;
    }
}