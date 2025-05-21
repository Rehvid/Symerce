<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\Auth\ForgotPasswordRequest;
use App\Admin\Application\DTO\Request\Profile\UpdateSecurityRequest;
use App\Admin\Application\UseCase\Auth\ForgotUserPasswordUseCase;
use App\Admin\Application\UseCase\Auth\LogoutUserUseCase;
use App\Admin\Application\UseCase\Auth\ResetUserPasswordUseCase;
use App\Admin\Application\UseCase\Auth\AuthorizeUserUseCase;
use App\Shared\Application\DTO\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/auth', name: 'auth_')]
final class AuthController extends AbstractController
{

    #[Route('/forgot-password', name: 'forgot_password', methods: ['POST'], format: 'json')]
    public function forgotPassword(
        #[MapRequestPayload] ForgotPasswordRequest $forgotPasswordRequestDTO,
        ForgotUserPasswordUseCase                  $useCase,
    ): JsonResponse {
        return $this->json($useCase->execute($forgotPasswordRequestDTO));
    }

    #[Route('/{token}/reset-password', name: 'reset_password', methods: ['PUT'])]
    public function resetPassword(
        string                                     $token,
        ResetUserPasswordUseCase                   $useCase,
        #[MapRequestPayload] UpdateSecurityRequest $changePasswordRequestDTO,
    ): JsonResponse {
        return $this->json($useCase->execute($changePasswordRequestDTO, $token));
    }

    #[Route('/logout', name: 'logout')]
    public function logout(LogoutUserUseCase $useCase): JsonResponse
    {
        return $useCase->execute();
    }

    #[Route('/verify', name: 'verify_auth', methods: ['GET'])]
    public function verifyAuth(AuthorizeUserUseCase $useCase): JsonResponse
    {
        $result = $useCase->execute();

        return $this->json(
            data: new ApiResponse(
                data: $result->authorized ? ['user' => $result->userSessionDTO] : [],
                error: $result->error,
            ),
            status: $result->statusCode
        );
    }
}
