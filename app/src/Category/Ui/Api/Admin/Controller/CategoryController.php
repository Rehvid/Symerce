<?php

declare(strict_types=1);

namespace App\Category\Ui\Api\Admin\Controller;

use App\Category\Application\Command\CreateCategoryCommand;
use App\Category\Application\Command\DeleteCategoryCommand;
use App\Category\Application\Command\UpdateCategoryCommand;
use App\Category\Application\Dto\Admin\Request\SaveCategoryRequest;
use App\Category\Application\Factory\CategoryDataFactory;
use App\Category\Application\Query\Admin\GetCategoryCreationContextQuery;
use App\Category\Application\Query\Admin\GetCategoryForEditQuery;
use App\Category\Application\Query\Admin\GetCategoryListQuery;
use App\Category\Application\Search\CategorySearchDefinition;
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

#[Route('/api/admin/categories', name: 'api_admin_category_')]
final class CategoryController extends AbstractApiController
{
    public function __construct(
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        private readonly CategoryDataFactory $categoryDataFactory,
    ) {
        parent::__construct($requestDtoResolver, $translator, $commandBus, $queryBus);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(
        Request $request,
        CategorySearchDefinition $definition,
        SearchDataFactory $factory,
    ): JsonResponse {
        return $this->json(
            data: $this->queryBus->ask(
                new GetCategoryListQuery(
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
                $this->queryBus->ask(new GetCategoryForEditQuery($id))
            ),
        );
    }

    #[Route('/store-data', name: 'store_data', methods: ['GET'])]
    public function storeData(): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                data: $this->queryBus->ask(new GetCategoryCreationContextQuery())
            )
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $categoryRequest = $this->requestDtoResolver->mapAndValidate($request, SaveCategoryRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreateCategoryCommand(
                data: $this->categoryDataFactory->fromRequest($categoryRequest)
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
        $categoryRequest = $this->requestDtoResolver->mapAndValidate($request, SaveCategoryRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateCategoryCommand(
                data: $this->categoryDataFactory->fromRequest($categoryRequest),
                categoryId: $id
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
        $this->commandBus->dispatch(new DeleteCategoryCommand($id));

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.destroy')
            )
        );
    }
}
