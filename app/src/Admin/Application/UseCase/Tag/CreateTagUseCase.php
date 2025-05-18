<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Tag;

use App\Admin\Application\Hydrator\TagHydrator;
use App\Admin\Domain\Repository\TagRepositoryInterface;
use App\Entity\Tag;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;

final readonly class CreateTagUseCase implements CreateUseCaseInterface
{
    public function __construct(
      private TagHydrator $hydrator,
      private TagRepositoryInterface $repository,
    ) {
    }

    public function execute(RequestDtoInterface $requestDto): array
    {
        $tag = $this->hydrator->hydrate($requestDto, new Tag());

        $this->repository->save($tag);

        return (new IdResponse($tag->getId()))->toArray();
    }
}
