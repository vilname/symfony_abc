<?php

declare(strict_types=1);

namespace App\Interface;

interface HandleInterface
{
    public function handle(CommandInterface $command);
}