<?php

declare(strict_types=1);

namespace App\Shop\Application\DTO\Request\ContactDetails;

final class SaveContactDetailsRequest
{
    public function __construct(
        public readonly string $firstname,
        public readonly string $surname,
        public readonly string $email,
        public readonly ?string $phone,
    ) {}
}
