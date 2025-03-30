<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Response\ErrorDTO;
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\Response\ApiResponse;
use App\Service\Response\ResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractApiController extends AbstractController
{
    public function __construct(
        protected readonly PersisterManager $dataPersisterManager,
        private readonly ResponseService    $responseService,
    )
    {
    }

    protected function prepareJsonResponse(
        mixed $data = [],
        ?array $meta = null,
        ?ErrorDTO $error = null,
        int $statusCode = Response::HTTP_OK,
        array $headers = [],
    ): JsonResponse {
        $response = new ApiResponse(
            data: $data,
            meta: $meta,
            error: $error,
        );

        return $this->responseService->createJsonResponse($response, $statusCode, $headers);
    }
}
