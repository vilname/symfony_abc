<?php

declare(strict_types=1);

namespace App\Common;

use App\Interface\ResultInterface;

class ErrorResult implements ResultInterface
{
    public string $message;

    public int $code;

    public string $type;

    public function __construct(
        string $message,
        int $code = 400
    ) {
        $this->message = $message;
        $this->code = $code;
        $this->type = 'error';
    }
}