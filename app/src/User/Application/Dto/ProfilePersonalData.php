<?php

declare(strict_types=1);

namespace App\User\Application\Dto;

use App\Admin\Domain\Model\FileData;

final readonly class ProfilePersonalData
{
    public function __construct(
        public string $firstname,
        public string $surname,
        public string $email,
        public int $id,
        public ?FileData $fileData
    ) {
    }
}
