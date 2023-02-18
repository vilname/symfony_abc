<?php

declare(strict_types=1);

namespace App\Exception;

use DomainException;
use Throwable;

class InvalidDateException extends DomainException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        if (empty($message)) {
            $message = 'Неверный формат даты';
        }

        if (empty($code)) {
            $code = 400;
        }

        parent::__construct($message, $code, $previous);
    }
}