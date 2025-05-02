<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RequestValidationException extends HttpException
{
    public function __construct(
        private readonly array $errors,
        int $statusCode = Response::HTTP_BAD_REQUEST
    ) {
        parent::__construct($statusCode, 'base.messages.errors.validation_failed');
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
