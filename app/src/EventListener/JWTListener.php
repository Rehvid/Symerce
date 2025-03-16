<?php

declare(strict_types=1);

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;

final readonly class JWTListener implements EventSubscriberInterface
{
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

        if ($token === null) {
            return;
        }

        try {
            $jwtTokenExpiry = (new \DateTime())->add(new \DateInterval('PT' . 9000 . 'S')); //TODO: Use it from yaml
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
            secure: $_SERVER['APP_ENV'] === 'prod',
            httpOnly: true,
            raw: true,
            sameSite: 'Strict'
        );
    }
}
