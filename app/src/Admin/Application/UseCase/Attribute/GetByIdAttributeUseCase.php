<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Attribute;

use App\Admin\Application\Assembler\AttributeAssembler;
use App\Admin\Domain\Repository\AttributeRepositoryInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetByIdAttributeUseCase implements GetByIdUseCaseInterface
{
    public function __construct(
        private AttributeRepositoryInterface $repository,
        private AttributeAssembler $assembler,
    ) {

    }

    public function execute(int|string $entityId): mixed
    {
        $attribute = $this->repository->findById($entityId);
        if (null === $attribute) {
            throw new EntityNotFoundException();
        }

        return $this->assembler->toFormDataResponse($attribute);
    }
}
