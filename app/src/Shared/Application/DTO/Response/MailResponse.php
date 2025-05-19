<?php

declare(strict_types=1);

namespace App\Shared\Application\DTO\Response;

use App\DTO\Admin\Response\ResponseInterfaceData;

readonly final class MailResponse implements ResponseInterfaceData
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
