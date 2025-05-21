<?php

declare(strict_types=1);

namespace App\Shared\Application\DTO\Response;

readonly final class MailResponse
{
    /** @param array<string, mixed> $context */
    public function __construct(
        public string $toEmail,
        public string $subject,
        public string $template,
        public array $context,
    ) {
    }
}
