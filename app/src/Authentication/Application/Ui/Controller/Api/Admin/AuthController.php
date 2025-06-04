<?php

declare(strict_types=1);

namespace App\Authentication\Application\Ui\Controller\Api\Admin;

use App\Admin\Application\DTO\Request\Profile\UpdateSecurityRequest;
use App\Admin\Application\UseCase\Auth\LogoutUserUseCase;
use App\Admin\Application\UseCase\Auth\ResetUserPasswordUseCase;
use App\Authentication\Application\Command\LogoutUserCommand;
use App\Authentication\Application\Command\RequestPasswordResetCommand;
use App\Authentication\Application\Command\ResetPasswordCommand;
use App\Authentication\Application\Command\VerifyUserAuthorizationCommand;
use App\Authentication\Application\Dto\AuthorizationResult;
use App\Authentication\Application\Dto\Request\ResetPasswordRequest;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Ui\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api/admin/auth', name: 'api_admin_auth_')]
final class AuthController extends AbstractApiController
{
    #[Route('/logout', name: 'logout')]
    public function logout(): JsonResponse
    {
        return $this->commandBus->handle(new LogoutUserCommand());
    }

    #[Route('/verify', name: 'verify_auth', methods: ['GET'])]
    public function verifyUserAuthorization(): JsonResponse
    {
        /** @var AuthorizationResult $authorizationResult */
        $authorizationResult = $this->commandBus->handle(new VerifyUserAuthorizationCommand());

        return $this->json(
            data: new ApiResponse(
                data: $authorizationResult->authorized ? ['user' => $authorizationResult->userSessionDTO] : [],
                error: $authorizationResult->error,
            ),
            status: $authorizationResult->statusCode
        );
    }

    #[Route('/forgot-password', name: 'forgot_password', methods: ['POST'], format: 'json')]
    public function forgotPassword(Request $request): JsonResponse
    {
        $resetPasswordRequest = $this->requestDtoResolver->mapAndValidate(
            $request,
            ResetPasswordRequest::class
        );

        return $this->json(
            data: $this->commandBus->handle(new RequestPasswordResetCommand(
                email: $resetPasswordRequest->email,
            ))
        );
    }

    #[Route('/{token}/reset-password', name: 'reset_password', methods: ['PUT'])]
    public function resetPassword(string $token, Request $request): JsonResponse
    {
        $resetPasswordRequest = $this->requestDtoResolver->mapAndValidate(
            $request,
            UpdateSecurityRequest::class
        );

        return $this->json(
            data: $this->commandBus->handle(
                new ResetPasswordCommand(
                    token: $token,
                    newPassword: $resetPasswordRequest->password
                )
            )
        );
    }
}
