<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Category;

use App\Admin\Application\Assembler\CategoryAssembler;
use App\Admin\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetByIdCategoryUseCase implements GetByIdUseCaseInterface
{
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private CategoryAssembler $assembler
    ) {
    }

    public function execute(int|string $entityId): array
    {
        $category = $this->repository->find($entityId);
        if (null === $category) {
            throw new EntityNotFoundException();
        }

        return $this->assembler->toFormDataResponse($category);
    }
}
