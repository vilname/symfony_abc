<?php

declare(strict_types=1);

namespace App\common;

class ResultPagination
{
    public int $pageSize;

    public int $page;

    public int $countPage;

    public function __construct(
        int $pageSize,
        int $page,
        int $countPage,
    ) {
        $this->pageSize = $pageSize;
        $this->page = $page;
        $this->countPage = $countPage;
    }
}
