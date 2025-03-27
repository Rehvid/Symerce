<?php

declare(strict_types=1);

namespace App\Service\Response;

final readonly class ApiResponse
{
    public function __construct(
        public mixed $data,
        public ?array $meta = null,
        public ?array $errors = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'meta' => $this->meta,
            'errors' => $this->errors,
        ];
    }
}
