<?php

declare(strict_types=1);

namespace App\Exception;

use DomainException;
use Throwable;

class WrongDateException extends DomainException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        if (empty($message)) {
            $message = 'Дата не может быть меньше 2021-01-01 числа';
        }

        if (empty($code)) {
            $code = 400;
        }

        parent::__construct($message, $code, $previous);
    }
}