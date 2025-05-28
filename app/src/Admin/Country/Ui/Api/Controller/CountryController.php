<?php

declare(strict_types=1);

namespace App\Admin\Country\Ui\Api\Controller;

use App\Admin\Country\Application\Command\CreateCountryCommand;
use App\Admin\Country\Application\Command\DeleteCountryCommand;
use App\Admin\Country\Application\Command\UpdateCountryCommand;
use App\Admin\Country\Application\Dto\CountryData;
use App\Admin\Country\Application\Dto\Request\SaveCountryRequest;
use App\Admin\Country\Application\Query\GetCountryForEditQuery;
use App\Admin\Country\Application\Query\GetCountryListQuery;
use App\Admin\Domain\Entity\Country;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Ui\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/admin/countries', name: 'api_admin_country_')]
final class CountryController extends AbstractApiController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        return $this->json(
            data: $this->queryBus->ask(new GetCountryListQuery($request)),
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $storeRequest = $this->requestDtoResolver->mapAndValidate($request, SaveCountryRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreateCountryCommand(
                new CountryData(
                    code: $storeRequest->code,
                    name: $storeRequest->name,
                    isActive: $storeRequest->isActive,
                )
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
    public function update(Country $country, Request $request): JsonResponse
    {
        $storeRequest = $this->requestDtoResolver->mapAndValidate($request, SaveCountryRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateCountryCommand(
                country: $country,
                countryData: new CountryData(
                    code: $storeRequest->code,
                    name: $storeRequest->name,
                    isActive: $storeRequest->isActive,
                )
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
    public function show(Country $country): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                $this->queryBus->ask(new GetCountryForEditQuery($country))
            ),
        );
    }

    #[Route('/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(Country $country): JsonResponse
    {
        $this->commandBus->dispatch(new DeleteCountryCommand($country));

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.destroy')
            )
        );
    }
}
