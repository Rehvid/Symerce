<?php

declare(strict_types=1);

namespace App\Category\Application\Handler\Command;

use App\Admin\Application\Service\SlugService;
use App\Category\Application\Command\CreateCategoryCommand;
use App\Category\Application\Hydrator\CategoryHydrator;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Domain\Entity\Category;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;

final readonly class CreateCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
       private CategoryHydrator $hydrator,
       private CategoryRepositoryInterface $repository,
       private SlugService $slugService,
    ) {}

    public function __invoke(CreateCategoryCommand $command): IdResponse
    {
        $category = $this->hydrator->hydrate($command->data);
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
