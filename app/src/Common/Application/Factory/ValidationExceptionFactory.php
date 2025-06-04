<?php

declare (strict_types = 1);

namespace App\Common\Application\Factory;

use App\Common\Infrastructure\Http\Exception\RequestValidationException;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class ValidationExceptionFactory
{
    public function __construct(
        private TranslatorInterface $translator
    ) {

    }

    public function createNotFound(string $field): void
    {
        throw new RequestValidationException([
            $field => ['message' => $this->translator->trans('base.validation.not_found', ['%entity%' => $field])]
        ]);
    }
}
