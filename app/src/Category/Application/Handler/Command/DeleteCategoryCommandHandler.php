<?php

declare(strict_types=1);

namespace App\Category\Application\Handler\Command;

use App\Category\Application\Command\DeleteCategoryCommand;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Application\Command\Interfaces\CommandHandlerInterface;

final readonly class DeleteCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CategoryRepositoryInterface $repository,
    ) {}

    public function __invoke(DeleteCategoryCommand $command): void
    {
        $this->repository->remove(
            $this->repository->findById($command->categoryId)
        );
    }
}
