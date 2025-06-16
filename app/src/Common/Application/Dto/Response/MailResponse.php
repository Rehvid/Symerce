<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Response;

final readonly class MailResponse
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
