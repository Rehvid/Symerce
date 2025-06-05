<?php

declare(strict_types=1);

namespace App\Category\Application\Handler\Command;

use App\Category\Application\Command\DeleteCategoryCommand;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Domain\Entity\Category;
use App\Common\Domain\Exception\EntityNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class DeleteCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CategoryRepositoryInterface $repository,
    ) {}

    public function __invoke(DeleteCategoryCommand $command): void
    {
        /** @var ?Category $category */
        $category = $this->repository->findById($command->categoryId);
        if (null === $category) {
            throw EntityNotFoundException::for(Category::class, $command->categoryId);
        }

        $this->repository->remove($category);
    }
}
