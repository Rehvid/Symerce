<?php

declare(strict_types=1);

namespace App\Setting\Ui\Api\Controller;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Application\Search\Factory\SearchDataFactory;
use App\Common\Infrastructure\Http\RequestDtoResolver;
use App\Common\Ui\Controller\Api\AbstractApiController;
use App\Setting\Application\Command\UpdateSettingCommand;
use App\Setting\Application\Dto\Request\UpdateSettingRequest;
use App\Setting\Application\Factory\SettingDataFactory;
use App\Setting\Application\Query\GetSettingForEditQuery;
use App\Setting\Application\Query\GetSettingListQuery;
use App\Common\Infrastructure\Bus\Command\CommandBusInterface;
use App\Common\Infrastructure\Bus\Query\QueryBusInterface;
use App\Setting\Application\Search\SettingSearchDefinition;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api/admin/settings', name: 'api_admin_setting_')]
final class SettingController extends AbstractApiController
{
    public function __construct(
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        private readonly SettingDataFactory $settingDataFactory,
    ) {
        parent::__construct($requestDtoResolver, $translator, $commandBus, $queryBus);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(
        Request $request,
        SettingSearchDefinition $definition,
        SearchDataFactory $factory
    ): JsonResponse
    {
        return $this->json(
            data: $this->queryBus->ask(
                new GetSettingListQuery(
                    searchData: $factory->fromRequest($request, $definition),
                )
            ),
        );
    }

    #[Route('/{id}', name: 'update', requirements: ['id' => '\d+'], methods: ['PUT'], format: 'json')]
    public function update(int $id, Request $request): JsonResponse
    {
        $updateRequest = $this->requestDtoResolver->mapAndValidate($request, UpdateSettingRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateSettingCommand(
                data: $this->settingDataFactory->fromRequest($updateRequest),
                settingId: $id
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
                    new GetSettingForEditQuery(
                        settingId: $id
                    )
                )
            ),
        );
    }

}
