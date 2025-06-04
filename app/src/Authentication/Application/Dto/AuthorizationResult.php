<?php

declare(strict_types=1);

namespace App\Authentication\Application\Dto;

use App\Common\Application\Dto\Response\ApiErrorResponse;
use App\User\Application\Dto\Response\UserSessionResponse;
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
