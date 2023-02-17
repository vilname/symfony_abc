<?php

declare(strict_types=1);

namespace App\Command\Score\List;

use App\Interface\CommandInterface;

class Command implements CommandInterface
{
    public int $pageSize;

    public ?int $page;

    public function __construct(int $pageSize, ?int $page = 1)
    {
        $this->pageSize = $pageSize;
        $this->page = !empty($page) ? $page : 1;
    }
}
