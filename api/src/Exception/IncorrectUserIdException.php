<?php

declare(strict_types=1);

namespace App\Exception;

use DomainException;
use Throwable;

class IncorrectUserIdException extends DomainException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        if (is_null($message)) {
            $message = 'Не передан id пользователя';
        }

        parent::__construct($message, $code, $previous);
    }
}