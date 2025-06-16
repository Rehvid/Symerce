<?php

declare(strict_types=1);

namespace App\User\Application\Dto\Response;

use App\Common\Application\Dto\Response\FileResponse;

final readonly class PersonalResponse
{
    public function __construct(
        public string $firstname,
        public string $surname,
        public string $email,
        public string $fullName,
        public ?FileResponse $avatar,
    ) {
    }
}
