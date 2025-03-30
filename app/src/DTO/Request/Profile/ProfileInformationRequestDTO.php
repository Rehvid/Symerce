<?php

namespace App\DTO\Request\Profile;

use App\Interfaces\PersistableInterface;

final readonly class ProfileInformationRequestDTO implements PersistableInterface
{
    public function __construct(
        public string $firstname,
        public string $surname,
        public string $email,
    ) {}
}
