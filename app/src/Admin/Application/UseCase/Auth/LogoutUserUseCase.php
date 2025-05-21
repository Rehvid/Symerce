<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Auth;

use App\Shared\Application\UseCases\Base\QueryUseCaseInterface;
use App\Shared\Domain\Enums\CookieName;
use App\Shared\Infrastructure\Http\CookieFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class LogoutUserUseCase implements QueryUseCaseInterface
{
    public function __construct(
        private CookieFactory $cookieFactory,
    ) {
    }

    public function execute(): JsonResponse
    {
        $response = new JsonResponse(['success' => true], Response::HTTP_OK);
        $response->headers->setCookie(
            $this->cookieFactory->create(CookieName::ADMIN_BEARER,'', 0)
        );

        return $response;
    }
}
