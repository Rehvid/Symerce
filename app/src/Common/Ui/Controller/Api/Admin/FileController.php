<?php

declare(strict_types=1);

namespace App\Common\Ui\Controller\Api\Admin;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Service\FileService;
use App\Common\Domain\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api/admin/files', name: 'api_admin_file_')]
final class FileController extends AbstractController
{
    public function __construct(
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route('/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(File $file, FileService $fileService): JsonResponse
    {
        $fileService->removeFileCompletely($file);

        return $this->json(
            data: new ApiResponse(message: $this->translator->trans('base.messages.destroy_file'))
        );
    }
}
