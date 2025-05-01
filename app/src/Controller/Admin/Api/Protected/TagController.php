<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\Tag\SaveTagRequestDTO;
use App\Entity\Tag;
use App\Mapper\TagResponseMapper;
use App\Repository\TagRepository;
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ResponseService;
use App\Service\SortableEntityOrderUpdater;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/tags', name: 'tag_')]
class TagController extends AbstractAdminController
{
    public function __construct(
        PersisterManager $dataPersisterManager,
        TranslatorInterface $translator,
        ResponseService $responseService,
        PaginationService $paginationService,
        SortableEntityOrderUpdater $sortableEntityOrderUpdater,
        private readonly TagResponseMapper $tagResponseMapper,
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
    public function index(Request $request, TagRepository $repository): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        return $this->prepareJsonResponse(
            data: $this->tagResponseMapper->mapToIndexResponse($paginatedResponse->data),
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(Tag $tag): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: $this->tagResponseMapper->mapToUpdateFormDataResponse(['tag' => $tag]),
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] SaveTagRequestDTO $persistable): JsonResponse
    {
        /** @var Tag $entity */
        $entity = $this->dataPersisterManager->persist($persistable);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.tag.store'),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Tag $tag,
        #[MapRequestPayload] SaveTagRequestDTO $persistable,
    ): JsonResponse {

        /** @var Tag $entity */
        $entity = $this->dataPersisterManager->update($persistable, $tag);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.tag.update')
        );
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(Tag $tag): JsonResponse
    {
        $this->dataPersisterManager->delete($tag);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.tag.destroy'));
    }
}
