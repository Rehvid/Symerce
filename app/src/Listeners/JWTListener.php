<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Entity\User;
use App\Service\JWTEventService;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class JWTListener implements EventSubscriberInterface
{
    public function __construct(
        private JWTEventService $jwtEventService,
        private TranslatorInterface $translator,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::AUTHENTICATION_SUCCESS => 'onAuthenticationSuccess',
            Events::AUTHENTICATION_FAILURE => 'onAuthenticationFailure',
            Events::JWT_EXPIRED => 'onJwtExpired',
            Events::JWT_NOT_FOUND => 'onJwtNotFound',
            Events::JWT_INVALID => 'onJwtInvalid',
        ];
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $token = $event->getData()['token'] ?? null;

        if (null === $token) {
            $this->jwtEventService->handleApiJWTErrorResponse(
                $event,
                $this->translator->trans('base.messages.errors.jwt.token_not_provided'),
            );

            return;
        }

        /** @var User $user */
        $user = $event->getUser();
        $this->jwtEventService->handleJwtSuccess($event, $user, $token);
    }

    public function onAuthenticationFailure(AuthenticationFailureEvent $event): void
    {
        $this->jwtEventService->handleJwtError(
            $event->getRequest(),
            $event,
            $this->translator->trans('base.messages.errors.jwt.invalid_credentials')
        );
    }

    public function onJwtExpired(JWTExpiredEvent $event): void
    {
        $this->jwtEventService->handleJwtError(
            $event->getRequest(),
            $event,
            $this->translator->trans('base.messages.errors.jwt.token_expired')
        );
    }

    public function onJwtNotFound(JWTNotFoundEvent $event): void
    {
        $this->jwtEventService->handleJwtError(
            $event->getRequest(),
            $event,
            $this->translator->trans('base.messages.errors.jwt.token_not_found')
        );
    }

    public function onJwtInvalid(AuthenticationFailureEvent $event): void
    {
        $this->jwtEventService->handleJwtError(
            $event->getRequest(),
            $event,
            $this->translator->trans('base.messages.errors.jwt.token_invalid')
        );
    }
}
