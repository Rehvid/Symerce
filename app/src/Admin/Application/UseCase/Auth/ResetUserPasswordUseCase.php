<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Auth;

use App\Admin\Application\DTO\Request\Profile\UpdateSecurityRequest;
use App\Admin\Application\Service\User\ResetUserPasswordService;
use App\Shared\Application\DTO\Response\ApiResponse;

final readonly class ResetUserPasswordUseCase
{
    public function __construct(
        private ResetUserPasswordService $resetPasswordService
    ) {
    }

    public function execute(UpdateSecurityRequest $changePasswordRequestDTO, string $token): ApiResponse
    {
        return $this->resetPasswordService->execute($changePasswordRequestDTO, $token);
    }
}
