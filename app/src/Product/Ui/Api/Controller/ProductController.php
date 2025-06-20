<?php

declare(strict_types=1);

namespace App\Product\Ui\Api\Controller;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Application\Search\Factory\SearchDataFactory;
use App\Common\Infrastructure\Bus\Command\CommandBusInterface;
use App\Common\Infrastructure\Bus\Query\QueryBusInterface;
use App\Common\Infrastructure\Http\RequestDtoResolver;
use App\Common\Ui\Controller\Api\AbstractApiController;
use App\Product\Application\Command\CreateProductCommand;
use App\Product\Application\Command\DeleteProductCommand;
use App\Product\Application\Command\UpdateProductCommand;
use App\Product\Application\Dto\Request\SaveProductRequest;
use App\Product\Application\Factory\ProductDataFactory;
use App\Product\Application\Query\GetProductCreationContextQuery;
use App\Product\Application\Query\GetProductForEditQuery;
use App\Product\Application\Query\GetProductHistoryQuery;
use App\Product\Application\Query\GetProductListQuery;
use App\Product\Application\Search\ProductSearchDefinition;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api/admin/products', name: 'api_admin_product_')]
final class ProductController extends AbstractApiController
{
    public function __construct(
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        private readonly ProductDataFactory $productDataFactory,
    ) {
        parent::__construct($requestDtoResolver, $translator, $commandBus, $queryBus);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(
        Request $request,
        ProductSearchDefinition $definition,
        SearchDataFactory $factory,
    ): JsonResponse {
        return $this->json(
            data: $this->queryBus->ask(
                new GetProductListQuery(
                    searchData: $factory->fromRequest($request, $definition),
                )
            ),
        );
    }

    #[Route('/store-data', name: 'store_data', methods: ['GET'])]
    public function storeData(): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                data: $this->queryBus->ask(new GetProductCreationContextQuery())
            )
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $productRequest = $this->requestDtoResolver->mapAndValidate($request, SaveProductRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreateProductCommand(
                data: $this->productDataFactory->createFromRequest($productRequest),
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
        $productRequest = $this->requestDtoResolver->mapAndValidate($request, SaveProductRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateProductCommand(
                productId: $id,
                data: $this->productDataFactory->createFromRequest($productRequest)
            )
        );

        return $this->json(
            data: new ApiResponse(
                data: $response->toArray(),
                message: $this->translator->trans('base.messages.update')
            )
        );
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                $this->queryBus->ask(
                    new GetProductForEditQuery(
                        productId: $id
                    )
                )
            ),
        );
    }

    #[Route('/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        $this->commandBus->dispatch(
            new DeleteProductCommand(
                productId: $id
            )
        );

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.destroy')
            )
        );
    }

    #[Route('/{id}/product-history', name: 'show_product_history', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showProductHistory(int $id): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                $this->queryBus->ask(
                    new GetProductHistoryQuery(
                        productId: $id
                    )
                )
            ),
        );
    }
}
