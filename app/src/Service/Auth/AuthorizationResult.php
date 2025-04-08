<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\DTO\Response\ErrorResponseDTO;
use App\DTO\Response\User\UserSessionResponseDTO;
use Symfony\Component\HttpFoundation\Response;

final readonly class AuthorizationResult
{
    public function __construct(
        public bool $authorized,
        public ?UserSessionResponseDTO $userSessionDTO = null,
        public ?ErrorResponseDTO $error = null,
        public int $statusCode = Response::HTTP_OK,
    ) {
    }
}
