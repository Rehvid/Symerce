<?php

declare (strict_types=1);

namespace App\Brand\Ui\Api\Controller;

use App\Brand\Application\Command\CreateBrandCommand;
use App\Brand\Application\Command\DeleteBrandCommand;
use App\Brand\Application\Command\UpdateBrandCommand;
use App\Brand\Application\Dto\Request\SaveBrandRequest;
use App\Brand\Application\Factory\BrandDataFactory;
use App\Brand\Application\Query\GetBrandForEditQuery;
use App\Brand\Application\Query\GetBrandListQuery;
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

#[Route('/api/admin/brands', name: 'api_admin_brand_')]
final class BrandController extends AbstractApiController
{
    public function __construct(
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        private readonly BrandDataFactory $brandDataFactory,
    ) {
        parent::__construct($requestDtoResolver, $translator, $commandBus, $queryBus);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        return $this->json(
            data: $this->queryBus->ask(new GetBrandListQuery($request)),
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $brandRequest = $this->requestDtoResolver->mapAndValidate($request, SaveBrandRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreateBrandCommand(
                data: $this->brandDataFactory->fromRequest($brandRequest),
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
        $brandRequest = $this->requestDtoResolver->mapAndValidate($request, SaveBrandRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateBrandCommand(
                data: $this->brandDataFactory->fromRequest( $brandRequest),
                brandId: $id
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
                    new GetBrandForEditQuery(
                        brandId: $id
                    )
                )
            ),
        );
    }

    #[Route('/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        $this->commandBus->dispatch(
            new DeleteBrandCommand(
                brandId: $id
            )
        );

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.destroy')
            )
        );
    }
}
