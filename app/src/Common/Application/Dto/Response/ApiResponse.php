<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Response;

final readonly class ApiResponse implements \JsonSerializable
{
    /**
     * @param array<string|int, mixed> $data
     * @param array<string, mixed>     $meta
     */
    public function __construct(
        private array $data = [],
        private array $meta = [],
        private ?ApiErrorResponse $error = null,
        private ?string $message = null,
    ) {

    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'data' => $this->data,
            'meta' => $this->meta,
            'errors' => $this->error,
            'message' => $this->message,
        ];
    }
}
