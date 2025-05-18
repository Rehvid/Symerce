<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\User;

use App\DTO\Admin\Response\FileResponseDTO;

final readonly class UserFormResponse extends UserCreateFormResponse
{
    public function __construct(
        public string $firstname,
        public string $surname,
        public string $email,
        public bool $isActive,
        public ?array $roles,
        public ?FileResponseDTO $avatar,
        array $availableRoles,
    ) {
        parent::__construct($availableRoles);
    }
}
