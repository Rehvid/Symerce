<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\AbstractApiController;
use App\DTO\Request\Profile\UpdateSecurityRequestDTO;
use App\DTO\Request\Profile\UpdatePersonalRequestDTO;
use App\DTO\Response\FileResponseDTO;
use App\DTO\Response\Profile\PersonalIndexResponseDTO;
use App\Entity\User;
use App\Service\FileService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profiles', name: 'profile_')]
class ProfileController extends AbstractApiController
{
    #[Route('/{id}', name: 'index', methods: ['GET'])]
    public function index(User $user): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: [
                'user' => PersonalIndexResponseDTO::fromArray([
                    'firstname' => $user->getFirstName(),
                    'surname' => $user->getSurname(),
                    'email' => $user->getUserIdentifier(),
                    'fullName' => $user->getFullName(),
                ]),
            ]
        );
    }

    #[Route('/{id}/personal', name: 'update_personal', methods: ['PUT'])]
    public function updatePersonal(
        User $user,
        FileService $fileService,
        #[MapRequestPayload] UpdatePersonalRequestDTO $profileInformationDTO
    ): JsonResponse {
        $this->dataPersisterManager->update($profileInformationDTO, $user);

        $fullName = $user->getFullName();
        return $this->prepareJsonResponse(
            data: [
                'user' => PersonalIndexResponseDTO::fromArray([
                    'firstname' => $user->getFirstName(),
                    'surname' => $user->getSurname(),
                    'email' => $user->getUserIdentifier(),
                    'fullName' => $fullName,
                    'avatar' => FileResponseDTO::fromArray([
                        'id' => $user->getAvatar()?->getId(),
                        'originalName' => "Avatar - $fullName",
                        'path' => $fileService->preparePublicPathToFile($user->getAvatar()?->getPath()),
                    ])
                ]),
            ],
            message: $this->translator->trans('base.messages.profile.update')
        );
    }

    #[Route('/{id}/security', name: 'update_security', methods: ['PUT'])]
    public function updateSecurity(
        User $user,
        #[MapRequestPayload] UpdateSecurityRequestDTO $changePasswordRequestDTO
    ): JsonResponse {
        $this->dataPersisterManager->update($changePasswordRequestDTO, $user);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.profile.update'));
    }
}
