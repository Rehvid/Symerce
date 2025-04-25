<?php

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\Currency\SaveCurrencyRequestDTO;
use App\DTO\Response\Currency\CurrencyFormResponseDTO;
use App\DTO\Response\Currency\CurrencyIndexResponseDTO;
use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/currencies', name: 'currency_')]
class CurrencyController extends AbstractAdminController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, CurrencyRepository $repository): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        $data = array_map(function (Currency $currency) {
            return CurrencyIndexResponseDTO::fromArray([
                'id' => $currency->getId(),
                'name' => $currency->getName(),
                'code' => $currency->getCode(),
                'symbol' => $currency->getSymbol(),
                'roundingPrecision' => $currency->getRoundingPrecision(),
            ]);
        }, $paginatedResponse->data);

        return $this->prepareJsonResponse(
            data: $data,
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(Currency $currency): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: [
                'formData' => CurrencyFormResponseDTO::fromArray([
                    'name' => $currency->getName(),
                    'symbol' => $currency->getSymbol(),
                    'code' => $currency->getCode(),
                    'roundingPrecision' => $currency->getRoundingPrecision(),
                ]),
            ]
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
