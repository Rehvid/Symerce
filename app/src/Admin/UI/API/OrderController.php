<?php

declare(strict_types=1);

namespace App\Admin\UI\API;


use App\Admin\Application\DTO\Request\Order\SaveOrderRequest;
use App\Admin\Application\UseCase\Order\CreateOrderUseCase;
use App\Admin\Application\UseCase\Order\DeleteOrderUseCase;
use App\Admin\Application\UseCase\Order\DetailOrderUseCase;
use App\Admin\Application\UseCase\Order\GetByIdOrderUseCase;
use App\Admin\Application\UseCase\Order\GetOrderCreateDataUseCase;
use App\Admin\Application\UseCase\Order\ListOrderUseCase;
use App\Admin\Application\UseCase\Order\UpdateOrderUseCase;

use App\Admin\Application\UseCase\Product\GetProductCreateDataUseCase;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Domain\Entity\Order;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/orders', name: 'order_')]
final class OrderController extends AbstractController
{

    public function __construct(
        private readonly RequestDtoResolver $requestDtoResolver,
        private readonly TranslatorInterface $translator
    ){

    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request, ListOrderUseCase $useCase): JsonResponse
    {

        return $this->json(
            data: $useCase->execute($request)
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request, CreateOrderUseCase $useCase): JsonResponse
    {
        $storeRequest = $this->requestDtoResolver->mapAndValidate($request, SaveOrderRequest::class);

        return $this->json(
            data: new ApiResponse(
                data: $useCase->execute($storeRequest),
                message: $this->translator->trans('base.messages.store')
            ),
            status: Response::HTTP_CREATED
        );
    }


    #[Route('/store-data', name: 'store_data', methods: ['GET'])]
    public function storeData(GetOrderCreateDataUseCase $useCase): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                data: $useCase->execute()
            )
        );
    }

    #[Route('/{id}', name: 'update', requirements: ['id' => '\d+'], methods: ['PUT'], format: 'json')]
    public function update(Request $request, string|int $id, UpdateOrderUseCase $useCase): JsonResponse
    {
        $storeRequest = $this->requestDtoResolver->mapAndValidate($request, SaveOrderRequest::class);

        return $this->json(
            data: new ApiResponse(
                data: $useCase->execute($storeRequest, $id),
                message: $this->translator->trans('base.messages.update')
            )
        );
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(string|int $id, GetByIdOrderUseCase $useCase): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(data: $useCase->execute($id)),
        );
    }

    #[Route('/{id}/details', name: 'detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(Order $order, DetailOrderUseCase $useCase): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                data: $useCase->execute($order),
            )
        );
    }
}
