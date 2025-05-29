<?php

declare(strict_types=1);

namespace App\Setting\Ui\Api\Controller;

use App\Admin\Domain\Entity\Setting;
use App\Setting\Application\Command\UpdateSettingCommand;
use App\Setting\Application\Dto\Request\UpdateSettingRequest;
use App\Setting\Application\Dto\SettingData;
use App\Setting\Application\Query\GetSettingForEditQuery;
use App\Setting\Application\Query\GetSettingListQuery;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Ui\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/admin/settings', name: 'api_admin_setting_')]
final class SettingController extends AbstractApiController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        return $this->json(
            data: $this->queryBus->ask(new GetSettingListQuery($request)),
        );
    }

    #[Route('/{id}', name: 'update', requirements: ['id' => '\d+'], methods: ['PUT'], format: 'json')]
    public function update(Setting $setting, Request $request): JsonResponse
    {
        $updateRequest = $this->requestDtoResolver->mapAndValidate($request, UpdateSettingRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdateSettingCommand(
                new SettingData(
                    setting: $setting,
                    name: $updateRequest->name,
                    settingValueType: $updateRequest->settingValueType,
                    value: $updateRequest->value,
                    isActive: $updateRequest->isActive,
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
    public function show(Setting $setting): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                $this->queryBus->ask(new GetSettingForEditQuery($setting))
            ),
        );
    }

}
