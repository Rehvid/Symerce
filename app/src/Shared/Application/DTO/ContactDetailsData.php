<?php

declare(strict_types=1);

namespace App\Shared\Application\DTO;

final readonly class ContactDetailsData
{
    public function __construct(
        public string $firstname,
        public string $surname,
        public string $phone,
    ) {}
}
