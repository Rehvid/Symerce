<?php

declare(strict_types=1);

namespace App\Category\Application\Handler\Command;

use App\Admin\Application\Service\SlugService;
use App\Category\Application\Command\UpdateCategoryCommand;
use App\Category\Application\Hydrator\CategoryHydrator;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Domain\Entity\Category;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;
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
            throw new NotFoundHttpException('Category not found');
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
