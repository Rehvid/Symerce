<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\Auth\ForgotPasswordRequest;
use App\Admin\Application\DTO\Request\Profile\UpdateSecurityRequest;
use App\Admin\Application\UseCase\Auth\ForgotPasswordUseCase;
use App\Admin\Application\UseCase\Auth\LogoutUseCase;
use App\Admin\Application\UseCase\Auth\ResetPasswordUseCase;
use App\Admin\Application\UseCase\Auth\VerifyAuthUseCase;
use App\Controller\AbstractApiController;
use App\Shared\Application\DTO\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/auth', name: 'auth_')]
final class AuthController extends AbstractController
{

    #[Route('/forgot-password', name: 'forgot_password', methods: ['POST'], format: 'json')]
    public function forgotPassword(
        #[MapRequestPayload] ForgotPasswordRequest $forgotPasswordRequestDTO,
        ForgotPasswordUseCase                      $useCase,
    ): JsonResponse {
        return $this->json($useCase->execute($forgotPasswordRequestDTO));
    }

    #[Route('/{token}/reset-password', name: 'reset_password', methods: ['PUT'])]
    public function resetPassword(
        string                                     $token,
        ResetPasswordUseCase $useCase,
        #[MapRequestPayload] UpdateSecurityRequest $changePasswordRequestDTO,
    ): JsonResponse {
        return $this->json($useCase->execute($changePasswordRequestDTO, $token));
    }

    #[Route('/logout', name: 'logout')]
    public function logout(LogoutUseCase $useCase): JsonResponse
    {
        return $useCase->execute();
    }

    #[Route('/verify', name: 'verify_auth', methods: ['GET'])]
    public function verifyAuth(Request $request, VerifyAuthUseCase $useCase): JsonResponse
    {
        $result = $useCase->execute($request);

        return $this->json(
            data: new ApiResponse(
                data: $result->authorized ? ['user' => $result->userSessionDTO] : [],
                error: $result->error,
            ),
            status: $result->statusCode
        );
    }
}
