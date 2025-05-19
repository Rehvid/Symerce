<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Admin\Application\DTO\Response\User\UserSessionResponse;
use App\Shared\Application\DTO\Response\ApiErrorResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class AuthorizationResult
{
    public function __construct(
        public bool                 $authorized,
        public ?UserSessionResponse $userSessionDTO = null,
        public ?ApiErrorResponse    $error = null,
        public int                  $statusCode = Response::HTTP_OK,
    ) {
    }
}
