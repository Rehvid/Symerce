<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Admin\Application\Service\FileService;
use App\Controller\AbstractApiController;
use App\Entity\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/files', name: 'file_')]
class FileController extends AbstractApiController
{
    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(File $file, FileService $fileService): JsonResponse
    {
        $fileService->removeFileCompletely($file);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.destroy_file'));
    }
}
