<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Attribute;

use App\Admin\Application\Hydrator\AttributeHydrator;
use App\Admin\Domain\Repository\AttributeRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class UpdateAttributeUseCase implements UpdateUseCaseInterface
{
    public function __construct(
        private AttributeRepositoryInterface $repository,
        private AttributeHydrator $hydrator,
    ) {
    }


    public function execute(RequestDtoInterface $requestDto, int|string $entityId): mixed
    {
        $attribute = $this->repository->findById($entityId);
        if (null === $attribute) {
            throw new EntityNotFoundException();
        }

        $this->hydrator->hydrate($requestDto, $attribute);
        $this->repository->save($attribute);

        return (new IdResponse($attribute->getId()))->toArray();
    }
}
