<?php

declare(strict_types=1);

namespace App\Country\Ui\Api\Controller;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Application\Search\Factory\SearchDataFactory;
use App\Common\Infrastructure\Http\RequestDtoResolver;
use App\Common\Ui\Controller\Api\AbstractApiController;
use App\Country\Application\Command\CreateCountryCommand;
use App\Country\Application\Command\DeleteCountryCommand;
use App\Country\Application\Command\UpdateCountryCommand;
use App\Country\Application\Dto\Request\SaveCountryRequest;
use App\Country\Application\Factory\CountryDataFactory;
use App\Country\Application\Query\GetCountryForEditQuery;
use App\Country\Application\Query\GetCountryListQuery;
use App\Common\Infrastructure\Bus\Command\CommandBusInterface;
use App\Common\Infrastructure\Bus\Query\QueryBusInterface;
use App\Country\Application\Search\CountrySearchDefinition;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api/admin/countries', name: 'api_admin_country_')]
final class CountryController extends AbstractApiController
{
    public function __construct(
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        private readonly CountryDataFactory $countryDataFactory,
    ) {
        parent::__construct($requestDtoResolver, $translator, $commandBus, $queryBus);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(
        Request $request,
        CountrySearchDefinition $definition,
        SearchDataFactory $factory,
    ): JsonResponse {
        return $this->json(
            data: $this->queryBus->ask(
                new GetCountryListQuery(
                    searchData: $factory->fromRequest($request, $definition),
                )
            ),
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $countryRequest = $this->requestDtoResolver->mapAndValidate($request, SaveCountryRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreateCountryCommand(
                data: $this->countryDataFactory->fromRequest($countryRequest)
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
        $countryRequest = $this->requestDtoResolver->mapAndValidate($request, SaveCountryRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateCountryCommand(
                countryId: $id,
                data: $this->countryDataFactory->fromRequest($countryRequest)
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
                    new GetCountryForEditQuery(
                        countryId: $id
                    )
                )
            ),
        );
    }

    #[Route('/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        $this->commandBus->dispatch(
            new DeleteCountryCommand(
                countryId: $id
            )
        );

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.destroy')
            )
        );
    }
}
