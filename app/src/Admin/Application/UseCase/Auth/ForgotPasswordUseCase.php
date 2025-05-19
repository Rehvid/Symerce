<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Auth;

use App\DTO\Admin\Request\User\ForgotPasswordRequestDTO;
use App\Shared\Application\DTO\Response\ApiErrorResponse;
use App\Service\Auth\ForgetPasswordService;
use App\Shared\Application\DTO\Response\ApiResponse;

final readonly class ForgotPasswordUseCase
{
    public function __construct(
        private ForgetPasswordService $forgetPasswordService,
    ) {
    }

    public function execute(ForgotPasswordRequestDTO $forgotPasswordRequestDTO): ApiResponse
    {
        try {
            $this->forgetPasswordService->sendMail($forgotPasswordRequestDTO);
            return new ApiResponse();
        } catch (\Throwable $exception) {
            return new ApiResponse(error: ApiErrorResponse::fromArray([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]));
        }
    }
}
