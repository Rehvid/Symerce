<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Auth;

use App\Admin\Application\DTO\Request\Auth\ForgotPasswordRequest;
use App\Admin\Application\Service\User\ForgetUserPasswordService;
use App\Shared\Application\DTO\Response\ApiResponse;

final readonly class ForgotUserPasswordUseCase
{
    public function __construct(
        private ForgetUserPasswordService $forgetPasswordService,
    ) {
    }

    public function execute(ForgotPasswordRequest $forgotPasswordRequestDTO): ApiResponse
    {
        return $this->forgetPasswordService->execute($forgotPasswordRequestDTO);
    }
}
