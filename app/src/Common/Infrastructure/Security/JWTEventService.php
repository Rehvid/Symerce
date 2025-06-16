<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Security;

use App\Common\Application\Dto\Response\ApiErrorResponse;
use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Domain\Entity\User;
use App\Common\Domain\Enums\CookieName;
use App\Common\Infrastructure\Http\CookieFactory;
use App\User\Application\Dto\Response\UserSessionResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
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

    public function handleJwtSuccess(AuthenticationSuccessEvent $event, User $user, string $token): void
    {
        $this->setCookieForResponse($event, $token);

        $response = $this->createApiResponse(
            $this->createDataForApiResponse($user)
        );

        $event->setData(
            $this->createApiResponse($this->createDataForApiResponse($user))->jsonSerialize()
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
            ),
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
