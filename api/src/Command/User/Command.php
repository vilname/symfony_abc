<?php

declare(strict_types=1);

namespace App\Command\User;

use App\Interface\CommandInterface;

class Command implements CommandInterface
{
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $phone;
    public string $email;
    public string $educationType;
    public bool $agreement;

    public function __construct(array $data)
    {
        $this->id = !empty($data['id']) ? (int)$data['id'] : null;
        $this->firstName = !empty($data['firstName']) ? $data['firstName'] : '';
        $this->lastName = !empty($data['lastName']) ? $data['lastName'] : '';
        $this->phone = !empty($data['phone']) ? $data['phone'] : '';
        $this->email = !empty($data['email']) ? $data['email'] : '';
        $this->educationType = !empty($data['educationType']) ? $data['educationType'] : '';
        $this->agreement = !empty($data['agreement']);
    }
}