<?php

declare(strict_types=1);

namespace App\User\Application\Dto\Response;

use App\Admin\Application\DTO\Response\FileResponse;

final readonly class UserFormResponse
{
    public function __construct(
        public string        $firstname,
        public string        $surname,
        public string        $email,
        public bool          $isActive,
        public ?array        $roles,
        public ?FileResponse $avatar,
    ) {

    }
}
