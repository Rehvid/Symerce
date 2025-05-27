<?php

declare(strict_types=1);

namespace App\Shared\Application\DTO\Request\ContactDetails;

use App\Shared\Application\DTO\Request\RequestDtoInterface;

final readonly class SaveContactDetailsRequest implements RequestDtoInterface
{
    public function __construct(
        public string $firstname,
        public string $surname,
        public string $email,
        public string $phone,
    ) {}
}
