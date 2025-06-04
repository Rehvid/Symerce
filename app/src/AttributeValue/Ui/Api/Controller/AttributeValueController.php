<?php

declare(strict_types=1);

namespace App\AttributeValue\Ui\Api\Controller;

use App\AttributeValue\Application\Command\CreateAttributeValueCommand;
use App\AttributeValue\Application\Command\DeleteAttributeValueCommand;
use App\AttributeValue\Application\Command\UpdateAttributeValueCommand;
use App\AttributeValue\Application\Dto\Request\SaveAttributeValueRequest;
use App\AttributeValue\Application\Factory\AttributeValueDataFactory;
use App\AttributeValue\Application\Query\GetAttributeValueForEditQuery;
use App\AttributeValue\Application\Query\GetAttributeValueListQuery;
use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Infrastructure\Bus\Command\CommandBusInterface;
use App\Common\Infrastructure\Bus\Query\QueryBusInterface;
use App\Common\Infrastructure\Http\RequestDtoResolver;
use App\Common\Ui\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api/admin/attributes/{attributeId}/values', name: 'api_admin_attribute_value')]
final class AttributeValueController extends AbstractApiController
{
    public function __construct(
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        private readonly AttributeValueDataFactory $attributeValueDataFactory,
    ) {
        parent::__construct($requestDtoResolver, $translator, $commandBus, $queryBus);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        return $this->json(
            data: $this->queryBus->ask(new GetAttributeValueListQuery($request)),
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $attributeValueRequest = $this->requestDtoResolver->mapAndValidate($request, SaveAttributeValueRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreateAttributeValueCommand(
                data: $this->attributeValueDataFactory->fromRequest($attributeValueRequest),
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
        $attributeValueRequest = $this->requestDtoResolver->mapAndValidate($request, SaveAttributeValueRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateAttributeValueCommand(
                attributeValueId: $id,
                data: $this->attributeValueDataFactory->fromRequest($attributeValueRequest)
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
                    new GetAttributeValueForEditQuery(
                        attributeValueId: $id
                    )
                )
            ),
        );
    }

    #[Route('/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        $this->commandBus->dispatch(
            new DeleteAttributeValueCommand(
                attributeValueId: $id
            )
        );

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.destroy')
            )
        );
    }
}
