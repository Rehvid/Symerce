<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Attribute;

use App\Admin\Domain\Repository\AttributeRepositoryInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DeleteAttributeUseCase implements DeleteUseCaseInterface
{
    public function __construct(
        private AttributeRepositoryInterface $repository,
    ) {
    }


    public function execute(int|string $entityId): void
    {
        $attribute = $this->repository->findById($entityId);
        if (null === $attribute) {
            throw new EntityNotFoundException();
        }

        $this->repository->remove($attribute);
    }
}
