<?php

declare(strict_types=1);

namespace App\Command\Auth\SignUp;

use App\Interface\CommandInterface;

class Command implements CommandInterface
{
    public string $firstName;

    public string $lastName;

    public string $phone;

    public string $email;

    public string $educationType;

    public string $password;

    public bool $agreement;

    public function __construct(array $data)
    {
        $this->firstName = !empty($data['firstName']) ? $data['firstName'] : '';
        $this->lastName = !empty($data['lastName']) ? $data['lastName'] : '';
        $this->phone = !empty($data['phone']) ? $data['phone'] : '';
        $this->email = !empty($data['email']) ? $data['email'] : '';
        $this->educationType = !empty($data['educationType']) ? $data['educationType'] : '';
        $this->password = !empty($data['password']) ? $data['password'] : '';
        $this->agreement = !empty($data['agreement']);
    }
}
