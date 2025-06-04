<?php

declare(strict_types=1);

namespace App\Authentication\Application\Handler\Command;

use App\Authentication\Application\Command\LogoutUserCommand;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Enums\CookieName;
use App\Shared\Infrastructure\Http\CookieFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class LogoutUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CookieFactory $cookieFactory,
    ) {}

    public function __invoke(LogoutUserCommand $command): Response
    {
        $response = new JsonResponse(['success' => true], Response::HTTP_OK);
        $response->headers->setCookie(
            $this->cookieFactory->create(CookieName::ADMIN_BEARER,'', 0)
        );

        return $response;
    }
}
