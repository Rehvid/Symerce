<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Admin\Response\ErrorResponseDTO;
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\Response\ApiResponse;
use App\Service\Response\ResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractApiController extends AbstractController
{
    public function __construct(
        protected readonly PersisterManager $dataPersisterManager,
        protected readonly TranslatorInterface $translator,
        private readonly ResponseService $responseService,
    ) {
    }

    /**
     * @param array<string|int, mixed> $data
     * @param array<string, mixed>     $meta
     * @param array<string, mixed>     $headers
     */
    protected function prepareJsonResponse(
        array $data = [],
        array $meta = [],
        ?ErrorResponseDTO $error = null,
        ?string $message = null,
        int $statusCode = Response::HTTP_OK,
        array $headers = [],
    ): JsonResponse {
        $response = new ApiResponse(
            data: $data,
            meta: $meta,
            error: $error,
            message: $message,
        );

        return $this->responseService->createJsonResponse($response, $statusCode, $headers);
    }
}
