<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Security;

use App\Admin\Application\DTO\Response\User\UserSessionResponse;
use App\Admin\Domain\Entity\User;
use App\Shared\Application\DTO\Response\ApiErrorResponse;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Domain\Enums\CookieName;
use App\Shared\Infrastructure\Http\CookieFactory;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class JWTEventService
{
    private int $tokenTtl;

    public function __construct(
        private ParameterBagInterface $params,
        private CookieFactory $cookieFactory,
    ) {
        /** @var int $tokenTtl */
        $tokenTtl = $this->params->get('lexik_jwt_authentication.token_ttl');
        $this->tokenTtl = $tokenTtl;
    }

    public function handleJwtSuccess(mixed $event, User $user, string $token): void
    {
        $this->setCookieForResponse($event, $token);

        $event->setData(
            [$this->createApiResponse($this->createDataForApiResponse($user))]
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
            error: new ApiErrorResponse(
                code: Response::HTTP_UNAUTHORIZED,
                message: $message
            )
        );

        $event->setResponse(
            new JsonResponse($apiResponse, Response::HTTP_UNAUTHORIZED)
        );
    }

    private function setCookieForResponse(mixed $event, string $token): void
    {
        try {
            $jwtTokenExpiry = (new \DateTime())->add(new \DateInterval('PT'.$this->tokenTtl.'S'));
        } catch (\Throwable) {
            $jwtTokenExpiry = 0;
        }

        $event->getResponse()->headers->setCookie(
            $this->cookieFactory->create(CookieName::ADMIN_BEARER, $token, $jwtTokenExpiry)
        );
    }

    /** @return array<string, mixed> */
    private function createDataForApiResponse(User $user): array
    {
        return [
            'user' => new UserSessionResponse(
                id: $user->getId(),
                email: $user->getUserIdentifier(),
                firstname: $user->getFirstname(),
                surname: $user->getSurname(),
                roles: $user->getRoles(),
                fullName: $user->getFullname(),
            )
        ];
    }

    private function isApiRequest(?Request $request): bool
    {
        return null !== $request && str_starts_with($request->getPathInfo(), '/api/');
    }

    /**
     * @param array<string, mixed> $data
     */
    private function createApiResponse(array $data = [], ?ApiErrorResponse $error = null): ApiResponse
    {
        return new ApiResponse(
            data: $data,
            error: $error,
        );
    }
}
