<?php

declare(strict_types=1);

namespace App\Shared\Application\DTO\Response;

use App\DTO\Admin\Response\ResponseInterfaceData;
use Symfony\Component\HttpFoundation\Response;

final readonly class ApiErrorResponse implements ResponseInterfaceData, \JsonSerializable
{
    /** @param array<string, mixed>|null $details */
    public function __construct(
        private int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        private string $message = 'Something went wrong',
        private ?array $details = null,
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

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'details' => $this->details,
        ];
    }
}
