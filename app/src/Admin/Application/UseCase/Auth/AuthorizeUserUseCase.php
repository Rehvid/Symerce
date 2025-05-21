<?php

declare (strict_types = 1);

namespace App\Admin\Application\UseCase\Auth;

use App\Admin\Application\DTO\AuthorizationResult;
use App\Admin\Application\Service\User\AuthorizeUserService;


final readonly class AuthorizeUserUseCase
{
    public function __construct(
        private AuthorizeUserService $authService,
    ) {
    }

    public function execute(): AuthorizationResult
    {
        return $this->authService->verifyUserAuthorization();
    }
}
