<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\AttributeValue;

use App\Admin\Application\Assembler\AttributeValueAssembler;
use App\Admin\Domain\Repository\AttributeValueRepositoryInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetByIdAttributeValueUseCase implements GetByIdUseCaseInterface
{
    public function __construct(
        private AttributeValueRepositoryInterface $repository,
        private AttributeValueAssembler          $assembler,
    ) {
    }

    public function execute(int|string $entityId): mixed
    {
        $attributeValue = $this->repository->findById($entityId);
        if (null === $attributeValue) {
            throw new EntityNotFoundException();
        }

        return $this->assembler->toFormDataResponse($attributeValue);
    }
}
