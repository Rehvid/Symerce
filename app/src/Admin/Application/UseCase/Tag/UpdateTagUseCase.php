<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Tag;

use App\Admin\Application\Hydrator\TagHydrator;
use App\Admin\Domain\Repository\TagRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class UpdateTagUseCase implements UpdateUseCaseInterface
{
    public function __construct(
        private TagRepositoryInterface $repository,
        private TagHydrator $hydrator,
    ) {

    }

    public function execute(RequestDtoInterface $requestDto, int|string $entityId): array
    {
        $tag = $this->repository->find($entityId);
        if (null === $tag) {
            throw new EntityNotFoundException();
        }

        $this->hydrator->hydrate($requestDto, $tag);

        $this->repository->save($tag);

        return (new IdResponse($tag->getId()))->toArray();
    }
}
