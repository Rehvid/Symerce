<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Tag;

use App\Admin\Application\Assembler\TagAssembler;
use App\Admin\Domain\Repository\TagRepositoryInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetByIdTagUseCase implements GetByIdUseCaseInterface
{
    public function __construct(
        private TagRepositoryInterface $repository,
        private TagAssembler $assembler
    ) {
    }

    public function execute(int|string $entityId): mixed
    {
        $tag = $this->repository->find($entityId);
        if (null === $tag) {
            throw new EntityNotFoundException();
        }

        return $this->assembler->toFormDataResponse($tag);
    }
}
