<?php

declare (strict_types = 1);

namespace App\Admin\Application\UseCase\AttributeValue;

use App\Admin\Domain\Repository\AttributeValueRepositoryInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DeleteAttributeValueUseCase implements DeleteUseCaseInterface
{
    public function __construct(
        private AttributeValueRepositoryInterface $repository,
    ) {
    }

    public function execute(int|string $entityId): void
    {
        $attributeValue = $this->repository->findById($entityId);
        if (null === $attributeValue) {
            throw new EntityNotFoundException();
        }
        $this->repository->remove($attributeValue);
    }
}
