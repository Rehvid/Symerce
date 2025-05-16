<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\DTO\Admin\Response\User\UserSessionResponseDTO;
use App\Shared\Application\DTO\Response\ApiErrorResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class AuthorizationResult
{
    public function __construct(
        public bool                    $authorized,
        public ?UserSessionResponseDTO $userSessionDTO = null,
        public ?ApiErrorResponse       $error = null,
        public int                     $statusCode = Response::HTTP_OK,
    ) {
    }
}
