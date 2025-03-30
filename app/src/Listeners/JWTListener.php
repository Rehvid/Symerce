<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Dto\Response\User\UserSessionResponseDTO;
use App\Entity\User;
use App\Service\Response\ApiResponse;
use App\Service\Response\ResponseService;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final readonly class JWTListener implements EventSubscriberInterface
{
    private int $tokenTtl;

    public function __construct(
        private ParameterBagInterface $params,
        private KernelInterface $kernel,
        private ResponseService $responseService,
    ){
        /** @var int $tokenTtl */
        $tokenTtl = $this->params->get('lexik_jwt_authentication.token_ttl');
        $this->tokenTtl = $tokenTtl;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::AUTHENTICATION_SUCCESS => 'onAuthenticationSuccess',
            Events::JWT_EXPIRED => 'onJwtExpired',
            Events::JWT_NOT_FOUND => 'onJwtNotFound',
        ];
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $token = $event->getData()['token'] ?? null;
        $response = $event->getResponse();

        if (null === $token) {
            return;
        }

        try {
            $jwtTokenExpiry = (new \DateTime())->add(new \DateInterval('PT'. $this->tokenTtl .'S'));
        } catch (\Throwable) {
            return;
        }

        $response->headers->setCookie(
            $this->createCookie('BEARER', $token, $jwtTokenExpiry)
        );

        /** @var User $user */
        $user = $event->getUser();
        $data = UserSessionResponseDTO::fromArray([
            'email' => $user->getUserIdentifier(),
            'firstname' => $user->getFirstname(),
            'surname' => $user->getSurname(),
            'roles' => $user->getRoles(),
        ]);

        $event->setData($this->createApiResponse($data)->toArray());
    }

    public function onJwtExpired(JwtExpiredEvent $event): void
    {
        $this->handleJwtError($event->getRequest(), $event, 'Token expired.');
    }

    public function onJwtNotFound(JwtNotFoundEvent $event): void
    {
        $this->handleJwtError($event->getRequest(), $event, 'Token not found.');
    }

    private function handleJwtError(Request $request, $event, string $message): void
    {
        if ($this->isApiRequest($request)) {
            $apiResponse = $this->createApiResponse(
                errors: ['status' => false, 'message' => $message, 'code' => Response::HTTP_UNAUTHORIZED],
            );

            $event->setResponse(
                $this->responseService->createJsonResponse($apiResponse, Response::HTTP_UNAUTHORIZED)
            );
            return;
        }

        $event->setResponse(new RedirectResponse('/admin/login', Response::HTTP_TEMPORARY_REDIRECT));
    }

    private function createCookie(string $name, string $value, \DateTimeInterface $expire): Cookie
    {
        return new Cookie(
            name: $name,
            value: $value,
            expire: $expire,
            secure: 'prod' === $this->kernel->getEnvironment(),
            httpOnly: true,
            raw: true,
            sameSite: 'strict'
        );
    }

    private function isApiRequest(Request $request): bool
    {
        return str_starts_with($request->getPathInfo(), '/api/');
    }

    private function createApiResponse(mixed $data = [], ?array $meta = null, ?array $errors = null): ApiResponse
    {
        return new ApiResponse(
            data: $data,
            meta: $meta,
            errors: $errors,
        );
    }
}
