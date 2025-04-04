<?php

declare(strict_types=1);

namespace App\Service\Response;

use App\DTO\Response\ErrorDTO;

final readonly class ApiResponse
{
    public function __construct(
        public array $data = [],
        public array $meta = [],
        public ?ErrorDTO $error = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'meta' => $this->meta,
            'errors' => $this->error === null ? [] : $this->error->toArray(),
        ];
    }
}
