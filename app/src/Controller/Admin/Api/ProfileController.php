<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api;

use App\Controller\AbstractApiController;
use App\DTO\Request\Profile\ChangePasswordRequestDTO;
use App\DTO\Request\Profile\ProfileInformationRequestDTO;
use App\DTO\Response\Profile\PersonalInformationResponseDTO;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile', name: 'profile_')]
class ProfileController extends AbstractApiController
{
    #[Route('/{id}/personal', name: 'personal', methods: ['GET'])]
    public function personal(User $user): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: PersonalInformationResponseDTO::fromArray([
                'firstname' => $user->getFirstName(),
                'surname' => $user->getSurname(),
                'email' => $user->getUserIdentifier()
            ])
        );
    }

    #[Route('/{id}/update-personal', name: 'update_personal', methods: ['PUT'])]
    public function updatePersonal(
        User                                              $user,
        #[MapRequestPayload] ProfileInformationRequestDTO $profileInformationDTO
    ): JsonResponse
    {
        $this->dataPersisterManager->update($profileInformationDTO, $user);

        return $this->prepareJsonResponse(
            PersonalInformationResponseDTO::fromArray([
                'firstname' => $user->getFirstName(),
                'surname' => $user->getSurname(),
                'email' => $user->getUserIdentifier()
            ])
        );
    }

    #[Route('/{id}/change-password', name: 'change_password', methods: ['PUT'])]
    public function changePassword(
        User $user,
        #[MapRequestPayload] ChangePasswordRequestDTO $changePasswordRequestDTO
    ): JsonResponse
    {
        $this->dataPersisterManager->update($changePasswordRequestDTO, $user);

        return $this->prepareJsonResponse();
    }
}
