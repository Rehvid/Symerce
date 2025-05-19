<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Auth;

use App\Admin\Application\DTO\Request\Profile\UpdateSecurityRequest;
use App\Service\Auth\ResetPasswordService;
use App\Shared\Application\DTO\Response\ApiErrorResponse;
use App\Shared\Application\DTO\Response\ApiResponse;

final readonly class ResetPasswordUseCase
{
    public function __construct(
        private ResetPasswordService $resetPasswordService
    ) {
    }

    public function execute(UpdateSecurityRequest $changePasswordRequestDTO, string $token): ApiResponse
    {
        try {
            $this->resetPasswordService->handleResetPassword($changePasswordRequestDTO, $token);
            return new ApiResponse();
        } catch (\Throwable $exception) {
            return new ApiResponse(
                error: ApiErrorResponse::fromArray([
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                ]),
            );
        }
    }
}
