<?php

declare(strict_types=1);

namespace App\DTO\Response;

use Symfony\Component\HttpFoundation\Response;

final class ErrorResponseDTO implements ResponseInterfaceData
{
    /** @param array<string, mixed>|null $details */
    private function __construct(
        public int $code,
        public string $message,
        public ?array $details = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'] ?? Response::HTTP_BAD_REQUEST,
            message: $data['message'] ?? 'Something went wrong',
            details: $data['details'] ?? null,
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'details' => $this->details,
        ];
    }
}
