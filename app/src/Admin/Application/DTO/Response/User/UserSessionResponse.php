<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\User;

use App\Admin\Application\DTO\Response\FileResponse;

final readonly class UserSessionResponse
{
    /** @param array<int|string>  $roles */
    public function __construct(
        public ?int          $id,
        public ?string       $email,
        public ?string       $firstname,
        public ?string       $surname,
        public array         $roles,
        public ?string       $fullName,
        public ?FileResponse $avatar = null,
    ) {
    }

}
