<?php

declare(strict_types=1);

namespace App\Customer\Ui\Api\Controller;

use App\Customer\Application\Command\CreateCustomerCommand;
use App\Customer\Application\Command\DeleteCustomerCommand;
use App\Customer\Application\Command\UpdateCustomerCommand;
use App\Customer\Application\Dto\Request\SaveCustomerRequest;
use App\Customer\Application\Factory\CustomerDataFactory;
use App\Customer\Application\Query\GetCustomerCreationContextQuery;
use App\Customer\Application\Query\GetCustomerForEditQuery;
use App\Customer\Application\Query\GetCustomerListQuery;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Domain\Entity\Customer;
use App\Shared\Infrastructure\Bus\Command\CommandBusInterface;
use App\Shared\Infrastructure\Bus\Query\QueryBusInterface;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use App\Shared\Ui\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api/admin/customers', name: 'api_admin_customer_')]
final class CustomerController extends AbstractApiController
{
    public function __construct(
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        private readonly CustomerDataFactory $customerDataFactory,
    ) {
        parent::__construct($requestDtoResolver, $translator, $commandBus, $queryBus);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        return $this->json(
            data: $this->queryBus->ask(new GetCustomerListQuery($request)),
        );
    }


    #[Route('/store-data', name: 'store_data', methods: ['GET'])]
    public function storeData(): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                data: $this->queryBus->ask(new GetCustomerCreationContextQuery())
            )
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $customerRequest = $this->requestDtoResolver->mapAndValidate($request, SaveCustomerRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreateCustomerCommand(
               data: $this->customerDataFactory->fromRequest($customerRequest),
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
                $this->queryBus->ask(
                    new GetCustomerForEditQuery(
                        customerId: $id
                    )
                )
            ),
        );
    }

    #[Route('/{id}', name: 'update', requirements: ['id' => '\d+'], methods: ['PUT'], format: 'json')]
    public function update(int $id, Request $request): JsonResponse
    {
        $customerRequest = $this->requestDtoResolver->mapAndValidate($request, SaveCustomerRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateCustomerCommand(
                data: $this->customerDataFactory->fromRequest($customerRequest),
                customerId: $id
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
            new DeleteCustomerCommand(
                customerId: $id
            )
        );

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.destroy')
            )
        );
    }


}
