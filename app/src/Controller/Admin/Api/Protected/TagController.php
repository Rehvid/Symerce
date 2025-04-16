<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\Tag\SaveTagRequestDTO;
use App\DTO\Response\Tag\TagFormResponseDTO;
use App\DTO\Response\Tag\TagIndexResponseDTO;
use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tags', name: 'tag_')]
class TagController extends AbstractAdminController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, TagRepository $repository): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        $data = array_map(function (array $item) {
            return TagIndexResponseDTO::fromArray([
                'id' => $item['id'],
                'name' => $item['name'],
            ]);
        }, $paginatedResponse->data);

        return $this->prepareJsonResponse(
            data: $data,
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(Tag $tag): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: [
                'formData' => TagFormResponseDTO::fromArray([
                    'name' => $tag->getName(),
                ])
            ]
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] SaveTagRequestDTO $dto): JsonResponse
    {
        /** @var Vendor $entity */
        $entity = $this->dataPersisterManager->persist($dto);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.vendor.store'),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Tag $tag,
        #[MapRequestPayload] SaveTagRequestDTO $dto,
    ): JsonResponse {

        $entity = $this->dataPersisterManager->update($dto, $tag);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.vendor.update')
        );
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(Tag $tag): JsonResponse
    {
        $this->dataPersisterManager->delete($tag);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.vendor.destroy'));
    }
}
