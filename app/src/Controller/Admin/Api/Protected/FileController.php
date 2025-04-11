<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\AbstractApiController;
use App\Entity\File;
use App\Service\FileService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/files', name: 'file_')]
class FileController extends AbstractApiController
{
    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(File $file, FileService $fileService): JsonResponse
    {
        $fileService->removeFile($file);
        $this->dataPersisterManager->delete($file);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.destroy_file'));
    }
}
