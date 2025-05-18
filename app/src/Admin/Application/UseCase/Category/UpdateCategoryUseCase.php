<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Category;

use App\Admin\Application\DTO\Request\Category\SaveCategoryRequest;
use App\Admin\Application\Hydrator\CategoryHydrator;
use App\Admin\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

/**
 * @implements UpdateUseCaseInterface<SaveCategoryRequest>
 */
final readonly class UpdateCategoryUseCase implements UpdateUseCaseInterface
{
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private CategoryHydrator $hydrator
    ) {
    }

    /** @return array<string, int> */
    public function execute(RequestDtoInterface $requestDto, int|string $entityId): array
    {
        $category = $this->repository->find($entityId);
        if (null === $category) {
            throw new EntityNotFoundException();
        }

        if (null !== $requestDto->slug && $category->getSlug() !== $requestDto->slug) {
            $category->setSlug($this->hydrator->generateSlug($requestDto->slug));
        }

        $this->hydrator->hydrate($requestDto, $category);

        $this->repository->save($category);

        return (new IdResponse($category->getId()))->toArray();
    }
}
