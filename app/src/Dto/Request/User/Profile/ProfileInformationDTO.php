<?php

namespace App\Dto\Request\User\Profile;

use App\Interfaces\PersistableInterface;

final readonly class ProfileInformationDTO implements PersistableInterface
{
    public function __construct(
        public string $firstname,
        public string $surname,
        public string $email,
    ) {}
}
