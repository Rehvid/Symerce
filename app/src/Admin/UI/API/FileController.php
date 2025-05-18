<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\UseCase\File\DeleteFileUseCase;
use App\Entity\File;
use App\Shared\Application\DTO\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/files', name: 'file_')]
final class FileController extends AbstractController
{
    public function __construct(
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route('/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(File $file, DeleteFileUseCase $useCase): JsonResponse
    {
        $useCase->execute($file);

        return $this->json(
            data: new ApiResponse(message: $this->translator->trans('base.messages.destroy_file'))
        );
    }
}
