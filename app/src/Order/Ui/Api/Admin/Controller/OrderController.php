<?php

declare(strict_types=1);

namespace App\Order\Ui\Api\Admin\Controller;

use App\Customer\Application\Query\GetCustomerCreationContextQuery;
use App\Customer\Application\Query\GetCustomerListQuery;
use App\Order\Application\Command\CreateOrderCommand;
use App\Order\Application\Command\DeleteOrderCommand;
use App\Order\Application\Command\UpdateOrderCommand;
use App\Order\Application\Dto\Request\SaveOrderRequest;
use App\Order\Application\Factory\OrderDataFactory;
use App\Order\Application\Query\GetOrderCreationContextQuery;
use App\Order\Application\Query\GetOrderDetailQuery;
use App\Order\Application\Query\GetOrderForEditQuery;
use App\Order\Application\Query\GetOrderListQuery;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Infrastructure\Bus\Command\CommandBusInterface;
use App\Shared\Infrastructure\Bus\Query\QueryBusInterface;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use App\Shared\Ui\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api/admin/orders', name: 'api_admin_order_')]
final class OrderController extends AbstractApiController
{
    public function __construct(
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        private readonly OrderDataFactory $orderDataFactory,
    ) {
        parent::__construct($requestDtoResolver, $translator, $commandBus, $queryBus);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        return $this->json(
            data: $this->queryBus->ask(new GetOrderListQuery($request)),
        );
    }

    #[Route('/{id}/details', name: 'detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(int $id): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                data: $this->queryBus->ask(new GetOrderDetailQuery($id)),
            )
        );
    }


    #[Route('/store-data', name: 'store_data', methods: ['GET'])]
    public function storeData(): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                data: $this->queryBus->ask(new GetOrderCreationContextQuery())
            )
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $customerRequest = $this->requestDtoResolver->mapAndValidate($request, SaveOrderRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreateOrderCommand(
                data: $this->orderDataFactory->fromRequest($customerRequest),
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

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                $this->queryBus->ask(new GetOrderForEditQuery($id))
            ),
        );
    }

    #[Route('/{id}', name: 'update', requirements: ['id' => '\d+'], methods: ['PUT'], format: 'json')]
    public function update(int $id, Request $request): JsonResponse
    {
        $orderRequest = $this->requestDtoResolver->mapAndValidate($request, SaveOrderRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateOrderCommand(
                data: $this->orderDataFactory->fromRequest($orderRequest),
                id: $id,
            )
        );

        return $this->json(
            data: new ApiResponse(
                data: $response->toArray(),
                message: $this->translator->trans('base.messages.update')
            )
        );
    }
}
