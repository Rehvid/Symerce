<?php

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\Currency\SaveCurrencyRequestDTO;
use App\Entity\Currency;
use App\Mapper\CurrencyResponseMapper;
use App\Repository\CurrencyRepository;
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ResponseService;
use App\Service\SortableEntityOrderUpdater;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/currencies', name: 'currency_')]
class CurrencyController extends AbstractAdminController
{
    public function __construct(
        PersisterManager $dataPersisterManager,
        TranslatorInterface $translator,
        ResponseService $responseService,
        PaginationService $paginationService,
        SortableEntityOrderUpdater $sortableEntityOrderUpdater,
        private readonly CurrencyResponseMapper $currencyResponseMapper,
    ) {
        parent::__construct(
            $dataPersisterManager,
            $translator,
            $responseService,
            $paginationService,
            $sortableEntityOrderUpdater
        );
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, CurrencyRepository $repository): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        return $this->prepareJsonResponse(
            data: $this->currencyResponseMapper->mapToIndexResponse($paginatedResponse->data),
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(Currency $currency): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: $this->currencyResponseMapper->mapToUpdateFormDataResponse(['currency' => $currency]),
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] SaveCurrencyRequestDTO $persistable): JsonResponse
    {
        /** @var Currency $entity */
        $entity = $this->dataPersisterManager->persist($persistable);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.currency.store'),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Currency $currency,
        #[MapRequestPayload] SaveCurrencyRequestDTO $persistable,
    ): JsonResponse {
        /** @var Currency $entity */
        $entity = $this->dataPersisterManager->update($persistable, $currency);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.currency.update')
        );
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(Currency $currency): JsonResponse
    {
        $this->dataPersisterManager->delete($currency);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.currency.destroy'));
    }
}
