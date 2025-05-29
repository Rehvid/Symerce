<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO;

use App\Shared\Application\DTO\Response\ApiErrorResponse;
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
