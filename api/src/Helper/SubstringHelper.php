<?php

declare(strict_types=1);

namespace App\Helper;

class SubstringHelper
{
    public static function getPhoneCode(string $phone): int
    {
        $matches = [];
        preg_match('/^(\d)(\d{3})/', $phone, $matches);

        return (int)$matches[2];
    }

    public static function getEmailCode(string $email): string
    {
        $emailCode = explode('@', $email);

        return explode('.', $emailCode[1])[0];
    }
}