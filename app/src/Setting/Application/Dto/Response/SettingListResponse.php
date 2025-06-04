<?php

declare(strict_types=1);

namespace App\Setting\Application\Dto\Response;


final readonly class SettingListResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public string $type,
        public bool $isActive,
    ) {
    }
}
