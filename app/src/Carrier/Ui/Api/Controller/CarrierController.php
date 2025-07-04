<?php

declare(strict_types=1);

namespace App\Carrier\Ui\Api\Controller;

use App\Carrier\Application\Command\CreateCarrierCommand;
use App\Carrier\Application\Command\DeleteCarrierCommand;
use App\Carrier\Application\Command\UpdateCarrierCommand;
use App\Carrier\Application\Dto\Request\SaveCarrierRequest;
use App\Carrier\Application\Factory\CarrierDataFactory;
use App\Carrier\Application\Query\GetCarrierForEditQuery;
use App\Carrier\Application\Query\GetCarrierListQuery;
use App\Carrier\Application\Search\CarrierSearchDefinition;
use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Application\Search\Factory\SearchDataFactory;
use App\Common\Infrastructure\Http\RequestDtoResolver;
use App\Common\Ui\Controller\Api\AbstractApiController;
use App\Common\Infrastructure\Bus\Command\CommandBusInterface;
use App\Common\Infrastructure\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api/admin/carriers', name: 'api_admin_carrier_')]
final class CarrierController extends AbstractApiController
{
    public function __construct(
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        private readonly CarrierDataFactory $carrierDataFactory,
    ) {
        parent::__construct($requestDtoResolver, $translator, $commandBus, $queryBus);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(
        Request $request,
        CarrierSearchDefinition $definition,
        SearchDataFactory $factory,
    ): JsonResponse {
        return $this->json(
            data: $this->queryBus->ask(
                new GetCarrierListQuery(
                    searchData: $factory->fromRequest($request, $definition),
                )
            ),
        );
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                $this->queryBus->ask(
                    new GetCarrierForEditQuery(
                        carrierId: $id
                    )
                )
            ),
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $carrierRequest = $this->requestDtoResolver->mapAndValidate($request, SaveCarrierRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreateCarrierCommand(
                data: $this->carrierDataFactory->fromRequest($carrierRequest)
            )
        );

        return $this->json(
            data: new ApiResponse(
                data: $response->toArray(),
                message: $this->translator->trans('base.messages.store')
            ),
            status: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'update', requirements: ['id' => '\d+'], methods: ['PUT'], format: 'json')]
    public function update(int $id, Request $request): JsonResponse
    {
        $carrierRequest = $this->requestDtoResolver->mapAndValidate($request, SaveCarrierRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateCarrierCommand(
                data: $this->carrierDataFactory->fromRequest($carrierRequest),
                carrierId: $id
            )
        );

        return $this->json(
            data: new ApiResponse(
                data: $response->toArray(),
                message: $this->translator->trans('base.messages.update')
            )
        );
    }

    #[Route('/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        $this->commandBus->dispatch(
            new DeleteCarrierCommand(
                carrierId: $id
            )
        );

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.destroy')
            )
        );
    }
}
