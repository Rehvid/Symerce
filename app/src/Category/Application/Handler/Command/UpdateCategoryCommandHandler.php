<?php

declare(strict_types=1);

namespace App\Category\Application\Handler\Command;

use App\Category\Application\Command\UpdateCategoryCommand;
use App\Category\Application\Hydrator\CategoryHydrator;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Application\Service\SlugService;
use App\Common\Domain\Entity\Category;
use App\Common\Domain\Exception\EntityNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class UpdateCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private CategoryHydrator $hydrator,
        private SlugService $slugService
    ) {}

    public function __invoke(UpdateCategoryCommand $command): IdResponse
    {
        /** @var ?Category $category */
        $category = $this->repository->findById($command->categoryId);
        if (null === $category) {
            throw EntityNotFoundException::for(Category::class, $command->categoryId);
        }
        $data = $command->data;

        $category = $this->hydrator->hydrate($data, $category);

        if ($data->slug !== $category->getSlug()) {
            $category->setSlug($this->slugService->makeUnique(
                fallback: $category->getSlug(),
                proposed: $data->slug,
                entityClass: Category::class
            ));
        }

        $this->repository->save($category);

        return new IdResponse($category->getId());
    }
}
