<?php

declare(strict_types=1);

namespace App\Category\Application\Handler\Command;

use App\Category\Application\Command\CreateCategoryCommand;
use App\Category\Application\Hydrator\CategoryHydrator;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Application\Service\SlugService;
use App\Common\Domain\Entity\Category;

final readonly class CreateCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CategoryHydrator $hydrator,
        private CategoryRepositoryInterface $repository,
        private SlugService $slugService,
    ) {
    }

    public function __invoke(CreateCategoryCommand $command): IdResponse
    {
        $category = $this->hydrator->hydrate($command->data, new Category());
        $category->setPosition($this->repository->getMaxPosition() + 1);
        $category->setSlug(
            $this->slugService->makeUnique(
                fallback: $category->getName(),
                proposed: $command->data->slug,
                entityClass: Category::class,
            )
        );

        $this->repository->save($category);

        return new IdResponse($category->getId());
    }
}
