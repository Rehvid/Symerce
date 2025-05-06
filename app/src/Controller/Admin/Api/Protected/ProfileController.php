<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\AbstractApiController;
use App\DTO\Admin\Request\Profile\UpdatePersonalRequestDTO;
use App\DTO\Admin\Request\Profile\UpdateSecurityRequestDTO;
use App\DTO\Admin\Response\FileResponseDTO;
use App\DTO\Admin\Response\Profile\PersonalIndexResponseDTO;
use App\Entity\User;
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\FileService;
use App\Service\RequestDtoResolver;
use App\Service\Response\ResponseService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/profiles', name: 'profile_')]
class ProfileController extends AbstractApiController
{
    public function __construct(
        PersisterManager $dataPersisterManager,
        TranslatorInterface $translator,
        ResponseService $responseService,
        protected readonly RequestDtoResolver $requestDtoResolver,
    ) {
        parent::__construct($dataPersisterManager, $translator, $responseService);
    }

    #[Route('/{id}', name: 'index', requirements: ['id' => '\d+'], methods: ['GET'])]
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

    #[Route('/{id}/personal', name: 'update_personal', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function updatePersonal(User $user, FileService $fileService, Request $request): JsonResponse
    {
        $persistable = $this->requestDtoResolver->mapAndValidate($request, UpdatePersonalRequestDTO::class);

        $this->dataPersisterManager->update($persistable, $user);
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
                    ]),
                ]),
            ],
            message: $this->translator->trans('base.messages.update')
        );
    }

    #[Route('/{id}/security', name: 'update_security', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function updateSecurity(User $user, Request $request): JsonResponse
    {
        $persistable = $this->requestDtoResolver->mapAndValidate($request, UpdateSecurityRequestDTO::class);

        $this->dataPersisterManager->update($persistable, $user);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.update'));
    }
}
