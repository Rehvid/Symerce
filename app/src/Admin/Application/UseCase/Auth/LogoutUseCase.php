<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Auth;

use App\Service\JWTEventService;
use App\Shared\Application\UseCases\Base\QueryUseCaseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class LogoutUseCase implements QueryUseCaseInterface
{
    public function __construct(
        private readonly JWTEventService $service
    ) {
    }

    public function execute(): JsonResponse
    {
        $response = new JsonResponse(['success' => true], Response::HTTP_OK);
        $response->headers->setCookie($this->service->createCookie('', 0));

        return $response;
    }
}
