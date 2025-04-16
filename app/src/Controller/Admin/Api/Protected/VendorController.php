<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\Vendor\VendorSaveRequestDTO;
use App\DTO\Response\FileResponseDTO;
use App\DTO\Response\Vendor\VendorFormResponseDTO;
use App\DTO\Response\Vendor\VendorIndexResponseDTO;
use App\Entity\Vendor;
use App\Repository\VendorRepository;
use App\Service\FileService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vendors', name: 'vendor_')]
class VendorController extends AbstractAdminController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, VendorRepository $repository, FileService $service): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        $data = array_map(function (array $item) use ($service) {
            return VendorIndexResponseDTO::fromArray([
                'id' => $item['id'],
                'name' => $item['name'],
                'imagePath' => $service->preparePublicPathToFile($item['path']),
            ]);
        }, $paginatedResponse->data);

        return $this->prepareJsonResponse(
            data: $data,
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] VendorSaveRequestDTO $dto): JsonResponse
    {
        /** @var Vendor $entity */
        $entity = $this->dataPersisterManager->persist($dto);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.vendor.store'),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(Vendor $vendor, FileService $service): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: [
                'formData' => VendorFormResponseDTO::fromArray([
                    'name' => $vendor->getName(),
                    'isActive' => $vendor->isActive(),
                    'image' => FileResponseDTO::fromArray([
                        'id' => $vendor->getImage()?->getId(),
                        'name' => "Avatar - {$vendor->getName()}",
                        'preview' => $service->preparePublicPathToFile($vendor->getImage()?->getPath()),
                    ])
                ])
            ]
        );
    }


    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Vendor $vendor,
        #[MapRequestPayload] VendorSaveRequestDTO $dto,
    ): JsonResponse {
        /** @var Vendor $entity */
        $entity = $this->dataPersisterManager->update($dto, $vendor);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.vendor.update')
        );
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(Vendor $vendor): JsonResponse
    {
        $this->dataPersisterManager->delete($vendor);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.vendor.destroy'));
    }
}
