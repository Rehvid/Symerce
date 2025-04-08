<?php

declare(strict_types=1);

namespace App\DTO\Response\Mail;

use App\DTO\Response\ResponseInterfaceData;

readonly class MailResponseDTO implements ResponseInterfaceData
{
    /** @param array<string, mixed> $context */
    private function __construct(
        public string $toEmail,
        public string $subject,
        public string $template,
        public array $context,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            toEmail: $data['toEmail'] ?? '',
            subject: $data['subject'] ?? '',
            template: $data['template'] ?? '',
            context: $data['context'] ?? [],
        );
    }
}
