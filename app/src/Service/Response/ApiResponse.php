<?php

declare(strict_types=1);

namespace App\Service\Response;

use App\Shared\Application\DTO\Response\ApiErrorResponse;

final readonly class ApiResponse
{
    /**
     * @param array<string|int, mixed> $data
     * @param array<string, mixed>     $meta
     */
    public function __construct(
        public array             $data = [],
        public array             $meta = [],
        public ?ApiErrorResponse $error = null,
        public ?string           $message = null,
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'meta' => $this->meta,
            'errors' => null === $this->error ? [] : $this->error->toArray(),
            'message' => $this->message,
        ];
    }
}
