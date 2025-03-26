<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api;

use App\Dto\Response\ApiResponse;
use App\Service\DataPersister\Manager\DataPersisterManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AbstractApiController extends AbstractController
{
    public function __construct(protected readonly DataPersisterManager $dataPersisterManager)
    {
    }

    protected function prepareJsonResponse(
        mixed $data = [],
        ?array $meta = null,
        ?array $errors = null,
        int $statusCode = Response::HTTP_OK
    ): JsonResponse {
        $response = new ApiResponse(
            data: $data,
            meta: $meta,
            errors: $errors,
        );

        return $this->json($response->toArray(), $statusCode);
    }
}
