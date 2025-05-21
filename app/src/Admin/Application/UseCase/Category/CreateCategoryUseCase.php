<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Category;

use App\Admin\Application\DTO\Request\Category\SaveCategoryRequest;
use App\Admin\Application\Hydrator\CategoryHydrator;
use App\Admin\Domain\Entity\Category;
use App\Admin\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;

/**
 * @implements CreateUseCaseInterface<SaveCategoryRequest>
 */
final readonly class CreateCategoryUseCase implements CreateUseCaseInterface
{
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private CategoryHydrator $hydrator
    ) {
    }

    /** @return array<string, int> */
    public function execute(RequestDtoInterface $requestDto): array
    {
       $category = new Category();
       $category->setOrder($this->repository->getMaxOrder());
       $category->setSlug($this->hydrator->saveSlug($requestDto->name, $requestDto->slug));

       $this->hydrator->hydrate($requestDto, $category);

       $this->repository->save($category);

       return (new IdResponse($category->getId()))->toArray();
    }
}
