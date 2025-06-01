<?php

declare(strict_types=1);

namespace App\Warehouse\Ui\Api\Controller;

use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Infrastructure\Bus\Command\CommandBusInterface;
use App\Shared\Infrastructure\Bus\Query\QueryBusInterface;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use App\Shared\Ui\AbstractApiController;
use App\Warehouse\Application\Command\CreateWarehouseCommand;
use App\Warehouse\Application\Command\DeleteWarehouseCommand;
use App\Warehouse\Application\Command\UpdateWarehouseCommand;
use App\Warehouse\Application\Dto\Request\SaveWarehouseRequest;
use App\Warehouse\Application\Factory\WarehouseDataFactory;
use App\Warehouse\Application\Query\GetWarehouseCreationContextQuery;
use App\Warehouse\Application\Query\GetWarehouseForEditQuery;
use App\Warehouse\Application\Query\GetWarehouseListQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api/admin/warehouses', name: 'api_admin_warehouse_')]
final class WarehouseController extends AbstractApiController
{
    public function __construct(
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        private WarehouseDataFactory $warehouseDataFactory,
    ) {
        parent::__construct($requestDtoResolver, $translator, $commandBus, $queryBus);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        return $this->json(
            data: $this->queryBus->ask(new GetWarehouseListQuery($request)),
        );
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                $this->queryBus->ask(
                    new GetWarehouseForEditQuery(
                        warehouseId: $id
                    )
                )
            ),
        );
    }

    #[Route('/store-data', name: 'store_data', methods: ['GET'])]
    public function storeData(): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                data: $this->queryBus->ask(new GetWarehouseCreationContextQuery())
            )
        );
    }


    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $warehouseRequest = $this->requestDtoResolver->mapAndValidate($request, SaveWarehouseRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreateWarehouseCommand(
                data: $this->warehouseDataFactory->fromRequest($warehouseRequest)
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
        $warehouseRequest = $this->requestDtoResolver->mapAndValidate($request, SaveWarehouseRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateWarehouseCommand(
                data: $this->warehouseDataFactory->fromRequest($warehouseRequest),
                warehouseId: $id
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
            new DeleteWarehouseCommand(
                warehouseId: $id
            )
        );

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.destroy')
            )
        );
    }
}
