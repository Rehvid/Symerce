<?php

declare(strict_types=1);

namespace App\DTO\Response;


use Symfony\Component\HttpFoundation\Response;

final class ErrorDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $code,
        public string $message,
        public ?array $details = null,
    ) {
    }

    /**
     * @return ErrorDTO
     */
    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            code: $data['code'] ?? Response::HTTP_BAD_REQUEST,
            message: $data['message'] ?? "Something went wrong",
            details: $data['details'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'details' => $this->details,
        ];
    }
}
