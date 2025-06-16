<?php

declare(strict_types=1);

namespace App\Tag\Ui\Api\Controller;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Application\Search\Factory\SearchDataFactory;
use App\Common\Infrastructure\Http\RequestDtoResolver;
use App\Common\Ui\Controller\Api\AbstractApiController;
use App\Common\Infrastructure\Bus\Command\CommandBusInterface;
use App\Common\Infrastructure\Bus\Query\QueryBusInterface;
use App\Tag\Application\Command\CreateTagCommand;
use App\Tag\Application\Command\DeleteTagCommand;
use App\Tag\Application\Command\UpdateTagCommand;
use App\Tag\Application\Dto\Request\SaveTagRequest;
use App\Tag\Application\Factory\TagDataFactory;
use App\Tag\Application\Query\GetTagForEditQuery;
use App\Tag\Application\Query\GetTagListQuery;
use App\Tag\Application\Search\TagSearchDefinition;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api/admin/tags', name: 'api_admin_tag_')]
final class TagController extends AbstractApiController
{
    public function __construct(
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        private readonly TagDataFactory $tagDataFactory
    ) {
        parent::__construct($requestDtoResolver, $translator, $commandBus, $queryBus);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(
        Request $request,
        TagSearchDefinition $definition,
        SearchDataFactory $factory
    ): JsonResponse {
        return $this->json(
            data: $this->queryBus->ask(
                new GetTagListQuery(
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
                    new GetTagForEditQuery(
                        tagId: $id
                    )
                )
            ),
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $tagRequest = $this->requestDtoResolver->mapAndValidate($request, SaveTagRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreateTagCommand(
                data: $this->tagDataFactory->fromRequest($tagRequest)
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
        $tagRequest = $this->requestDtoResolver->mapAndValidate($request, SaveTagRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateTagCommand(
                data: $this->tagDataFactory->fromRequest($tagRequest),
                tagId: $id
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
        $this->commandBus->dispatch(new DeleteTagCommand($id));

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.destroy')
            )
        );
    }
}
