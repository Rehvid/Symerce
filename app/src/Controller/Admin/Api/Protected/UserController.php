<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\User\SaveUserRequestDTO;
use App\DTO\Response\FileResponseDTO;
use App\DTO\Response\User\UserFormResponseDTO;
use App\DTO\Response\User\UserIndexResponseDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\FileService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users', name: 'user_')]
class UserController extends AbstractAdminController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, UserRepository $repository, FileService $service): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        $userData = array_map(function (User $user) use ($service) {
            return UserIndexResponseDTO::fromArray([
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'fullName' => $user->getFullName(),
                'isActive' => $user->isActive(),
                'imagePath' => $service->preparePublicPathToFile($user->getAvatar()?->getPath()),
            ]);
        }, $paginatedResponse->data);


        return $this->prepareJsonResponse(
            data: $userData,
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(User $user, FileService $service): JsonResponse
    {
        $data = [];
        $fullName = $user->getFullName();
        $data['formData'] = UserFormResponseDTO::fromArray([
            'firstname' => $user->getFirstname(),
            'surname' => $user->getSurname(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'isActive' => $user->isActive(),
            'avatar' => FileResponseDTO::fromArray([
                'id' => $user->getAvatar()?->getId(),
                'name' => "Avatar - $fullName",
                'preview' => $service->preparePublicPathToFile($user->getAvatar()?->getPath()),
            ]),
        ]);


        return $this->prepareJsonResponse(data: $data);
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] SaveUserRequestDTO $persistable): JsonResponse
    {
        /** @var User $entity */
        $entity = $this->dataPersisterManager->persist($persistable);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.user.store'),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        User $user,
        #[MapRequestPayload] SaveUserRequestDTO $persistable,
    ): JsonResponse {
        /** @var User $entity */
        $entity = $this->dataPersisterManager->update($persistable, $user);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.user.update')
        );
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(User $user): JsonResponse
    {
        $this->dataPersisterManager->delete($user);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.user.destroy'));
    }
}
