<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RequestValidationException extends HttpException
{
    /** @param array<string, mixed> $errors */
    public function __construct(
        private readonly array $errors,
        int $statusCode = Response::HTTP_BAD_REQUEST
    ) {
        parent::__construct($statusCode, 'base.messages.errors.validation_failed');
    }

    /** @return array<string, mixed> */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
