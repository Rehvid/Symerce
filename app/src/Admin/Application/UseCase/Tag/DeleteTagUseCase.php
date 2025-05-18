<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Tag;

use App\Admin\Domain\Repository\TagRepositoryInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DeleteTagUseCase implements DeleteUseCaseInterface
{
    public function __construct(
        private TagRepositoryInterface $repository
    ) {
    }

    public function execute(int|string $entityId): void
    {
        $tag = $this->repository->find($entityId);
        if (null === $tag) {
            throw new EntityNotFoundException();
        }

        $this->repository->remove($tag);
    }
}
