<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Response\ErrorResponseDTO;
use App\DTO\Response\ResponseInterfaceData;
use App\Repository\Interface\PaginationRepositoryInterface;
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ApiResponse;
use App\Service\Response\ResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractApiController extends AbstractController
{
    public function __construct(
        protected readonly PersisterManager $dataPersisterManager,
        protected readonly TranslatorInterface $translator,
        private readonly ResponseService $responseService,
        private readonly PaginationService $paginationService,
    ) {
    }

    protected function getPaginatedResponse(
        Request $request,
        PaginationRepositoryInterface $paginationRepository,
        string $responseInterfaceDataClass,
    ): JsonResponse {
        $paginationResponse = $this->paginationService->buildPaginationResponse($request, $paginationRepository);

        if (!is_subclass_of($responseInterfaceDataClass, ResponseInterfaceData::class)) {
            return $this->prepareJsonResponse(
                error: ErrorResponseDTO::fromArray([
                    'code' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Class must be an instance of ResponseInterfaceData.',
                ])
            );
        }

        return $this->prepareJsonResponse(
            data: array_map(fn ($data) => $responseInterfaceDataClass::fromArray($data), $paginationResponse->data),
            meta: $paginationResponse->paginationMeta->toArray()
        );
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
