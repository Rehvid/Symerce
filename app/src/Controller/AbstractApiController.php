<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\DataPersister\Manager\DataPersisterManager;
use App\Service\Response\ApiResponse;
use App\Service\Response\ResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractApiController extends AbstractController
{
    public function __construct(
        protected readonly DataPersisterManager $dataPersisterManager,
        private readonly ResponseService $responseService,
    )
    {
    }

    protected function prepareJsonResponse(
        mixed $data = [],
        ?array $meta = null,
        ?array $errors = null,
        int $statusCode = Response::HTTP_OK,
        array $headers = [],
    ): JsonResponse {
        $response = new ApiResponse(
            data: $data,
            meta: $meta,
            errors: $errors,
        );

        return $this->responseService->createJsonResponse($response, $statusCode, $headers);
    }
}
