<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Response\ErrorResponseDTO;
use App\DTO\Response\User\UserSessionResponseDTO;
use App\Entity\User;
use App\Service\Response\ApiResponse;
use App\Service\Response\ResponseService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final readonly class JWTEventService
{
    private int $tokenTtl;

    public function __construct(
        private ResponseService $responseService,
        private ParameterBagInterface $params,
        private KernelInterface $kernel,
    ) {
        /** @var int $tokenTtl */
        $tokenTtl = $this->params->get('lexik_jwt_authentication.token_ttl');
        $this->tokenTtl = $tokenTtl;
    }

    public function handleJwtSuccess(mixed $event, User $user, string $token): void
    {
        $this->setCookieForResponse($event, $token);

        $event->setData(
            $this->createApiResponse($this->createDataForApiResponse($user))->toArray()
        );
    }

    public function handleJwtError(?Request $request, mixed $event, string $message): void
    {
        if ($this->isApiRequest($request)) {
            $this->handleApiJWTErrorResponse($event, $message);

            return;
        }

        $event->setResponse(
            new RedirectResponse('/admin/public/login', Response::HTTP_TEMPORARY_REDIRECT)
        );
    }

    public function handleApiJWTErrorResponse(mixed $event, string $message): void
    {
        $apiResponse = $this->createApiResponse(
            error: ErrorResponseDTO::fromArray([
                'message' => $message,
                'code' => Response::HTTP_UNAUTHORIZED,
            ])
        );

        $event->setResponse(
            $this->responseService->createJsonResponse($apiResponse, Response::HTTP_UNAUTHORIZED)
        );
    }

    private function setCookieForResponse(mixed $event, string $token): void
    {
        try {
            $jwtTokenExpiry = (new \DateTime())->add(new \DateInterval('PT'.$this->tokenTtl.'S'));
        } catch (\Throwable) {
            $jwtTokenExpiry = 0;
        }

        $event->getResponse()->headers->setCookie($this->createCookie($token, $jwtTokenExpiry));
    }

    /** @return array<string, mixed> */
    private function createDataForApiResponse(User $user): array
    {
        $data = [];
        $data['user'] = UserSessionResponseDTO::fromArray([
            'id' => $user->getId(),
            'email' => $user->getUserIdentifier(),
            'firstname' => $user->getFirstname(),
            'surname' => $user->getSurname(),
            'roles' => $user->getRoles(),
            'fullName' => $user->getFullname(),
        ]);

        return $data;
    }

    private function isApiRequest(?Request $request): bool
    {
        return null !== $request && str_starts_with($request->getPathInfo(), '/api/');
    }

    /**
     * @param array<string, mixed> $data
     */
    private function createApiResponse(array $data = [], ?ErrorResponseDTO $error = null): ApiResponse
    {
        return new ApiResponse(
            data: $data,
            error: $error,
        );
    }

    private function createCookie(string $value, \DateTimeInterface|int $expire): Cookie
    {
        return new Cookie(
            name: 'BEARER',
            value: $value,
            expire: $expire,
            secure: 'prod' === $this->kernel->getEnvironment(),
            httpOnly: true,
            raw: true,
            sameSite: 'strict'
        );
    }
}
