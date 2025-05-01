<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\User\SaveUserRequestDTO;
use App\Entity\User;
use App\Mapper\UserResponseMapper;
use App\Repository\UserRepository;
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ResponseService;
use App\Service\SortableEntityOrderUpdater;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/users', name: 'user_')]
class UserController extends AbstractAdminController
{
    public function __construct(
        PersisterManager $dataPersisterManager,
        TranslatorInterface $translator,
        ResponseService $responseService,
        PaginationService $paginationService,
        SortableEntityOrderUpdater $sortableEntityOrderUpdater,
        private readonly UserResponseMapper $userResponseMapper,
    ) {
        parent::__construct(
            $dataPersisterManager,
            $translator,
            $responseService,
            $paginationService,
            $sortableEntityOrderUpdater
        );
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, UserRepository $repository): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        return $this->prepareJsonResponse(
            data: $this->userResponseMapper->mapToIndexResponse($paginatedResponse->data),
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(User $user): JsonResponse
    {
        return $this->prepareJsonResponse(
            data:
            $this->userResponseMapper->mapToUpdateFormDataResponse(['user' => $user])
        );
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
