<?php

declare(strict_types=1);

namespace App\Service\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class ResponseService
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function createJsonResponse(
        ApiResponse $response,
        int $statusCode = Response::HTTP_OK,
        array $headers = []
    ): JsonResponse {
        return new JsonResponse(
            data: $this->serializer->serialize($response->toArray(), 'json'),
            status: $statusCode,
            headers: $headers,
            json: true
        );
    }
}
