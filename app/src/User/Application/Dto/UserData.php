<?php

declare(strict_types=1);

namespace App\User\Application\Dto;

use App\Admin\Domain\Model\FileData;

final readonly class UserData
{
    public function __construct(
        public string $email,
        public string $firstname,
        public string $surname,
        public array $roles,
        public bool $isActive,
        public ?int $id = null,
        public ?string $password = null,
        public ?string $passwordConfirmation = null,
        public ?FileData $avatar = null
    ) {}
}
