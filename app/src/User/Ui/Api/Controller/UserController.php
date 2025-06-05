<?php

declare(strict_types=1);

namespace App\User\Ui\Api\Controller;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Application\Search\Factory\SearchDataFactory;
use App\Common\Infrastructure\Http\RequestDtoResolver;
use App\Common\Ui\Controller\Api\AbstractApiController;
use App\Common\Infrastructure\Bus\Command\CommandBusInterface;
use App\Common\Infrastructure\Bus\Query\QueryBusInterface;
use App\User\Application\Command\CreateUserCommand;
use App\User\Application\Command\DeleteUserCommand;
use App\User\Application\Command\UpdateUserCommand;
use App\User\Application\Dto\Request\SaveUserRequest;
use App\User\Application\Factory\UserDataFactory;
use App\User\Application\Query\GetUserCreationContextQuery;
use App\User\Application\Query\GetUserForEditQuery;
use App\User\Application\Query\GetUserListQuery;
use App\User\Application\Search\UserSearchDefinition;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api/admin/users', name: 'api_admin_user_')]
final class UserController extends AbstractApiController
{
    public function __construct(
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        private readonly UserDataFactory $userDataFactory,
    ) {
        parent::__construct($requestDtoResolver, $translator, $commandBus, $queryBus);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(
        Request $request,
        UserSearchDefinition $definition,
        SearchDataFactory $factory
    ): JsonResponse {
        return $this->json(
            data: $this->queryBus->ask(
                new GetUserListQuery(
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
                data: $this->queryBus->ask(new GetUserCreationContextQuery())
            )
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $userRequest = $this->requestDtoResolver->mapAndValidate($request, SaveUserRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreateUserCommand(
               data: $this->userDataFactory->fromRequest($userRequest),
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
        $userRequest = $this->requestDtoResolver->mapAndValidate($request, SaveUserRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateUserCommand(
                data: $this->userDataFactory->fromRequest($userRequest),
                userId: $id
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
                    new GetUserForEditQuery(
                        userId: $id
                    )
                )
            ),
        );
    }

    #[Route('/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        $this->commandBus->dispatch(
            new DeleteUserCommand(
                userId: $id
            )
        );

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.destroy')
            )
        );
    }
}
