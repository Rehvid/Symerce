<?php

declare(strict_types=1);

namespace App\EventListener;

use DateInterval;
use DateTime;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\KernelInterface;

final readonly class JWTListener implements EventSubscriberInterface
{
    private int $tokenTtl;

    public function __construct(private ParameterBagInterface $params, private KernelInterface $kernel)
    {
        /** @var int $tokenTtl */
        $tokenTtl = $this->params->get('lexik_jwt_authentication.token_ttl');
        $this->tokenTtl = $tokenTtl;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::AUTHENTICATION_SUCCESS => 'onAuthenticationSuccess',
            Events::JWT_AUTHENTICATED => 'onAuthenticatedAccess',
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
            $jwtTokenExpiry = (new DateTime())->add(new DateInterval('PT'.$this->tokenTtl.'S'));
        } catch (\Throwable) {
            return;
        }

        $response->headers->setCookie(
            $this->createCookie('BEARER', $token, $jwtTokenExpiry)
        );
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
}
