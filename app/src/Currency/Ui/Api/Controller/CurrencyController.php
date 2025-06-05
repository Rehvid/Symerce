<?php

declare(strict_types=1);

namespace App\Currency\Ui\Api\Controller;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Application\Search\Factory\SearchDataFactory;
use App\Common\Infrastructure\Http\RequestDtoResolver;
use App\Common\Ui\Controller\Api\AbstractApiController;
use App\Currency\Application\Command\CreateCurrencyCommand;
use App\Currency\Application\Command\DeleteCurrencyCommand;
use App\Currency\Application\Command\UpdateCurrencyCommand;
use App\Currency\Application\Dto\Request\SaveCurrencyRequest;
use App\Currency\Application\Factory\CurrencyDataFactory;
use App\Currency\Application\Query\GetCurrencyForEditQuery;
use App\Currency\Application\Query\GetCurrencyListQuery;
use App\Common\Infrastructure\Bus\Command\CommandBusInterface;
use App\Common\Infrastructure\Bus\Query\QueryBusInterface;
use App\Currency\Application\Search\CurrencySearchDefinition;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api/admin/currencies', name: 'api_admin_currency_')]
final class CurrencyController extends AbstractApiController
{
    public function __construct(
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        private readonly CurrencyDataFactory $currencyDataFactory,
    ) {
        parent::__construct($requestDtoResolver, $translator, $commandBus, $queryBus);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(
        Request $request,
        CurrencySearchDefinition $definition,
        SearchDataFactory $factory,
    ): JsonResponse
    {
        return $this->json(
            data: $this->queryBus->ask(
                new GetCurrencyListQuery(
                    searchData: $factory->fromRequest($request, $definition),
                )
            ),
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $currencyRequest = $this->requestDtoResolver->mapAndValidate($request, SaveCurrencyRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreateCurrencyCommand(
                data: $this->currencyDataFactory->fromRequest($currencyRequest)
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
        $currencyRequest = $this->requestDtoResolver->mapAndValidate($request, SaveCurrencyRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateCurrencyCommand(
                data: $this->currencyDataFactory->fromRequest($currencyRequest),
                currencyId: $id
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
                    new GetCurrencyForEditQuery(
                        currencyId: $id
                    )
                )
            ),
        );
    }

    #[Route('/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        $this->commandBus->dispatch(
            new DeleteCurrencyCommand(
                currencyId: $id
            )
        );

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.destroy')
            )
        );
    }
}
