<?php

declare(strict_types=1);

namespace App\Command\Auth\SignUp;

use App\Exception\IncorrectEducationTypeException;
use App\Exception\UserAlreadyExistsException;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HandleTest extends KernelTestCase
{
    private const FIRST_NAME = 'Иван';
    private const LAST_NAME = 'Иванов';
    private const PHONE = '89111111111';
    private const EMAIL = 'test@mail.ru';
    private const PASSWORD = '123';
    private const EDUCATION = 'higher';
    private const AGREEMENT = '1';

    public function testSuccess()
    {
        $command = new Command([
            'firstName' => self::FIRST_NAME,
            'lastName' => self::LAST_NAME,
            'phone' => self::PHONE,
            'email' => self::EMAIL,
            'educationType' => self::EDUCATION,
            'password' => self::PASSWORD,
            'agreement' => self::AGREEMENT,
        ]);

        self::bootKernel();
        $container = self::getContainer();
        $handle = $container->get(Handle::class);
        $result = $handle->handle($command);
        $token = json_decode($result->getContent(), true);

        $this->assertInstanceOf(JWTAuthenticationSuccessResponse::class, $result);
        $this->assertNotEmpty($token['token']);
    }

    public function testUniqueEmailFail()
    {
        $this->expectException(UserAlreadyExistsException::class);

        $command = new Command([
            'firstName' => self::FIRST_NAME,
            'lastName' => self::LAST_NAME,
            'phone' => self::PHONE,
            'email' => self::EMAIL,
            'educationType' => self::EDUCATION,
            'password' => self::PASSWORD,
            'agreement' => self::AGREEMENT,
        ]);


        self::bootKernel();
        $container = self::getContainer();
        $handle = $container->get(Handle::class);
        $handle->handle($command);
    }

    public function testEmptyEducationFail()
    {
        $this->expectException(IncorrectEducationTypeException::class);

        $command = new Command([
            'firstName' => self::FIRST_NAME,
            'lastName' => self::LAST_NAME,
            'phone' => self::PHONE,
            'email' => 'test2@mail.com',
            'password' => self::PASSWORD,
            'agreement' => self::AGREEMENT,
        ]);


        self::bootKernel();
        $container = self::getContainer();
        $handle = $container->get(Handle::class);
        $handle->handle($command);
    }

    public function testIncorrectEducationFail()
    {
        $this->expectException(IncorrectEducationTypeException::class);

        $command = new Command([
            'firstName' => self::FIRST_NAME,
            'lastName' => self::LAST_NAME,
            'phone' => self::PHONE,
            'email' => 'test3@mail.com',
            'educationType' => 'test',
            'password' => self::PASSWORD,
            'agreement' => self::AGREEMENT,
        ]);


        self::bootKernel();
        $container = self::getContainer();
        $handle = $container->get(Handle::class);
        $handle->handle($command);
    }
}