<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractApiController;
use App\DTO\Request\OrderRequestDTO;
use App\Interfaces\OrderSortableInterface;
use App\Repository\Interface\PaginationRepositoryInterface;
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\Pagination\PaginationResponse;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ResponseService;
use App\Service\SortableEntityOrderUpdater;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    /** @param array<string,mixed> $additionalData */
    protected function getPaginatedResponse(
        Request $request,
        PaginationRepositoryInterface $paginationRepository,
        array $additionalData = []
    ): PaginationResponse {
        return $this->paginationService->buildPaginationResponse($request, $paginationRepository, $additionalData);
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
