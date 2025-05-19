<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\AttributeValue;

use App\Admin\Application\Hydrator\AttributeValueHydrator;
use App\Admin\Domain\Repository\AttributeValueRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class UpdateAttributeValueUseCase implements UpdateUseCaseInterface
{
    public function __construct(
        private AttributeValueRepositoryInterface $repository,
        private AttributeValueHydrator $hydrator,
    ) {
    }

    public function execute(RequestDtoInterface $requestDto, int|string $entityId): mixed
    {
        $attributeValue = $this->repository->findById($entityId);
        if (null === $attributeValue) {
            throw new EntityNotFoundException();
        }

        $this->hydrator->hydrate($requestDto, $attributeValue);
        $this->repository->save($attributeValue);

        return (new IdResponse($attributeValue->getId()))->toArray();
    }
}
