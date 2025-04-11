<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractApiController;
use App\DTO\Request\OrderRequestDTO;
use App\DTO\Response\ErrorResponseDTO;
use App\DTO\Response\ResponseInterfaceData;
use App\Interfaces\OrderSortableInterface;
use App\Repository\Interface\PaginationRepositoryInterface;
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ResponseService;
use App\Service\SortableEntityOrderUpdater;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class AbstractAdminController extends AbstractApiController
{
    public function __construct(
        PersisterManager $dataPersisterManager,
        TranslatorInterface $translator,
        ResponseService $responseService,
        private readonly PaginationService $paginationService,
        private readonly SortableEntityOrderUpdater $sortableEntityOrderUpdater,
    ) {
        parent::__construct($dataPersisterManager, $translator, $responseService);
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
     * @param class-string<OrderSortableInterface> $class
     */
    protected function sortOrderForEntity(OrderRequestDTO $dto, string $class): JsonResponse
    {
        $this->sortableEntityOrderUpdater->updateOrder($dto, $class);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.update_order'));
    }
}
