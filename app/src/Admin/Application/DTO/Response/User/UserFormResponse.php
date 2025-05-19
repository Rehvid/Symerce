<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\User;

use App\Admin\Application\DTO\Response\FileResponse;

final readonly class UserFormResponse extends UserCreateFormResponse
{
    public function __construct(
        public string        $firstname,
        public string        $surname,
        public string        $email,
        public bool          $isActive,
        public ?array        $roles,
        public ?FileResponse $avatar,
        array                $availableRoles,
    ) {
        parent::__construct($availableRoles);
    }
}
