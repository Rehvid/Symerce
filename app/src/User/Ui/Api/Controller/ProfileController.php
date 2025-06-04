<?php

declare(strict_types=1);

namespace App\User\Ui\Api\Controller;

use App\Admin\Application\UseCase\Profile\UpdateSecurityUseCase;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Ui\AbstractApiController;
use App\User\Application\Command\UpdateUserProfilePersonalCommand;
use App\User\Application\Command\UpdateUserProfileSecurityCommand;
use App\User\Application\Dto\Request\UpdatePersonalRequest;
use App\User\Application\Dto\Request\UpdateSecurityRequest;
use App\User\Application\Factory\ProfilePersonalDataFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/admin/profiles', name: 'api_admin_profile_')]
final class ProfileController extends AbstractApiController
{
    #[Route('/{id}/personal', name: 'update_personal', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function updatePersonal(Request $request, int $id, ProfilePersonalDataFactory $factory): JsonResponse
    {
        $personalRequest = $this->requestDtoResolver->mapAndValidate($request, UpdatePersonalRequest::class);

        return $this->json(
            data: new ApiResponse(
                data: $this->commandBus->handle(new UpdateUserProfilePersonalCommand(
                    userId: $id,
                    data: $factory->fromRequest($personalRequest),
                )),
                message: $this->translator->trans('base.messages.update')
            )
        );
    }

    #[Route('/{id}/security', name: 'update_security', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function updateSecurity(int $id, Request $request, UpdateSecurityUseCase $useCase): JsonResponse
    {
        $securityRequest = $this->requestDtoResolver->mapAndValidate($request, UpdateSecurityRequest::class);
        $this->commandBus->dispatch(new UpdateUserProfileSecurityCommand(
            userId: $id,
            newPassword: $securityRequest->password
        ));

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.update')
            )
        );
    }
}
