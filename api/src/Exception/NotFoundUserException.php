<?php

declare(strict_types=1);

namespace App\Exception;

use DomainException;
use Throwable;

class NotFoundUserException extends DomainException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        if (is_null($message)) {
            $message = 'Пользователь не найден';
        }

        parent::__construct($message, $code, $previous);
    }
}