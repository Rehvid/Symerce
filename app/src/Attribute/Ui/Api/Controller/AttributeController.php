<?php

declare(strict_types=1);

namespace App\Attribute\Ui\Api\Controller;

use App\Attribute\Application\Command\CreateAttributeCommand;
use App\Attribute\Application\Command\DeleteAttributeCommand;
use App\Attribute\Application\Command\UpdateAttributeCommand;
use App\Attribute\Application\Dto\Request\SaveAttributeRequest;
use App\Attribute\Application\Factory\AttributeDataFactory;
use App\Attribute\Application\Query\GetAttributeCreationContextQuery;
use App\Attribute\Application\Query\GetAttributeForEditQuery;
use App\Attribute\Application\Query\GetAttributeListQuery;
use App\Attribute\Application\Search\AttributeSearchDefinition;
use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Application\Search\Factory\SearchDataFactory;
use App\Common\Infrastructure\Bus\Command\CommandBusInterface;
use App\Common\Infrastructure\Bus\Query\QueryBusInterface;
use App\Common\Infrastructure\Http\RequestDtoResolver;
use App\Common\Ui\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api/admin/attributes', name: 'api_admin_attribute_')]
final class AttributeController extends AbstractApiController
{
    public function __construct(
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        private readonly AttributeDataFactory $attributeDataFactory,
    ) {
        parent::__construct($requestDtoResolver, $translator, $commandBus, $queryBus);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(
        Request $request,
        AttributeSearchDefinition $definition,
        SearchDataFactory $factory
    ): JsonResponse {
        return $this->json(
            data: $this->queryBus->ask(
                 new GetAttributeListQuery(
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
                data: $this->queryBus->ask(new GetAttributeCreationContextQuery())
            )
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $attributeRequest = $this->requestDtoResolver->mapAndValidate($request, SaveAttributeRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreateAttributeCommand(
                data: $this->attributeDataFactory->fromRequest($attributeRequest),
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
        $attributeRequest = $this->requestDtoResolver->mapAndValidate($request, SaveAttributeRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateAttributeCommand(
                attributeId: $id,
                data: $this->attributeDataFactory->fromRequest($attributeRequest)
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
                    new GetAttributeForEditQuery(
                        attributeId: $id
                    )
                )
            ),
        );
    }

    #[Route('/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        $this->commandBus->dispatch(
            new DeleteAttributeCommand(
                attributeId: $id
            )
        );

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.destroy')
            )
        );
    }
}
