<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Public;

use App\Admin\Application\DTO\Request\Profile\UpdateSecurityRequest;
use App\Controller\AbstractApiController;
use App\DTO\Admin\Request\User\ForgotPasswordRequestDTO;
use App\DTO\Admin\Request\User\StoreRegisterUserRequestDTO;
use App\Service\Auth\AuthService;
use App\Service\Auth\ForgetPasswordService;
use App\Service\Auth\ResetPasswordService;
use App\Service\JWTEventService;
use App\Shared\Application\DTO\Response\ApiErrorResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/auth', name: 'auth_')]
class AuthController extends AbstractApiController
{
    #[Route('/register', name: 'register', methods: ['POST'], format: 'json')]
    public function register(#[MapRequestPayload] StoreRegisterUserRequestDTO $saveUserDTO): JsonResponse
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
            return $this->prepareJsonResponse(error: ApiErrorResponse::fromArray([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]));
        }

        return $this->prepareJsonResponse();
    }

    #[Route('/{token}/reset-password', name: 'reset_password', methods: ['PUT'])]
    public function resetPassword(
        string                                     $token,
        ResetPasswordService                       $resetPasswordService,
        #[MapRequestPayload] UpdateSecurityRequest $changePasswordRequestDTO,
    ): JsonResponse {
        try {
            $resetPasswordService->handleResetPassword($changePasswordRequestDTO, $token);
        } catch (\Throwable $exception) {
            return $this->prepareJsonResponse(
                error: ApiErrorResponse::fromArray([
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                ]),
                statusCode: $exception->getCode()
            );
        }

        return $this->prepareJsonResponse();
    }

    #[Route('/logout', name: 'logout')]
    public function logout(JWTEventService $service): JsonResponse
    {
        $response = new JsonResponse(['success' => true], Response::HTTP_OK);
        $response->headers->setCookie($service->createCookie('', 0));

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
