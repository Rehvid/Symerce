<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Public;

use App\Controller\AbstractApiController;
use App\DTO\Request\Profile\UpdateSecurityRequestDTO;
use App\DTO\Request\User\ForgotPasswordRequestDTO;
use App\DTO\Request\User\RegisterUserRequestDTO;
use App\DTO\Response\ErrorResponseDTO;
use App\Service\Auth\AuthService;
use App\Service\Auth\ForgetPasswordService;
use App\Service\Auth\ResetPasswordService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/auth', name: 'auth_')]
class AuthController extends AbstractApiController
{
    #[Route('/register', name: 'register', methods: ['POST'], format: 'json')]
    public function register(#[MapRequestPayload] RegisterUserRequestDTO $saveUserDTO): JsonResponse
    {
        $this->dataPersisterManager->persist($saveUserDTO);

        return $this->prepareJsonResponse(statusCode: Response::HTTP_CREATED);
    }

    #[Route('/forgot-password', name: 'forgot_password', methods: ['POST'], format: 'json')]
    public function forgotPassword(
        ForgetPasswordService $forgetPasswordService,
        #[MapRequestPayload] ForgotPasswordRequestDTO $forgotPasswordRequestDTO
    ): JsonResponse {
        try {
            $forgetPasswordService->sendMail($forgotPasswordRequestDTO);
        } catch (\Throwable $exception) {
            return $this->prepareJsonResponse(error: ErrorResponseDTO::fromArray([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]));
        }

        return $this->prepareJsonResponse();
    }

    #[Route('/{token}/reset-password', name: 'reset_password', methods: ['PUT'])]
    public function resetPassword(
        string $token,
        ResetPasswordService $resetPasswordService,
        #[MapRequestPayload] UpdateSecurityRequestDTO $changePasswordRequestDTO,
    ): JsonResponse {
        try {
            $resetPasswordService->handleResetPassword($changePasswordRequestDTO, $token);
        } catch (\Throwable $exception) {
            return $this->prepareJsonResponse(
                error: ErrorResponseDTO::fromArray([
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                ]),
                statusCode: $exception->getCode()
            );
        }

        return $this->prepareJsonResponse();
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): JsonResponse
    {
        $response = new JsonResponse(['success' => true], Response::HTTP_OK);
        $response->headers->removeCookie('BEARER');

        return $response;
    }

    #[Route('/verify', name: 'verify_auth', methods: ['GET'])]
    public function verifyAuth(
        Request $request,
        AuthService $authService,
    ): JsonResponse {
        $result = $authService->verifyUserAuthorization($request);

        return $this->prepareJsonResponse(
            data: $result->authorized ? ['user' => $result->userSessionDTO] : [],
            error: $result->error,
            statusCode: $result->statusCode,
        );
    }
}
