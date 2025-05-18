<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Category;

use App\Admin\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DeleteCategoryUseCase implements DeleteUseCaseInterface
{
    public function __construct(
        private CategoryRepositoryInterface $repository,
    ) {
    }


    public function execute(int|string $entityId): void
    {
        $category = $this->repository->find($entityId);
        if (null === $category) {
            throw new EntityNotFoundException();
        }

        $this->repository->remove($category);
    }
}
