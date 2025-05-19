<?php

declare (strict_types = 1);

namespace App\Admin\Application\UseCase\Auth;

use App\Service\Auth\AuthorizationResult;
use App\Service\Auth\AuthService;
use App\Shared\Application\DTO\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Request;

final readonly class VerifyAuthUseCase
{
    public function __construct(
        private AuthService $authService,
    ) {

    }

    public function execute(Request $request): AuthorizationResult
    {
        return $this->authService->verifyUserAuthorization($request);
    }
}
