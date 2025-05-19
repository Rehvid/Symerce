<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\AttributeValue;

use App\Admin\Application\Hydrator\AttributeValueHydrator;
use App\Admin\Domain\Repository\AttributeRepositoryInterface;
use App\Admin\Domain\Repository\AttributeValueRepositoryInterface;
use App\Entity\AttributeValue;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class CreateAttributeValueUseCase implements CreateUseCaseInterface
{
    public function __construct(
        private AttributeValueRepositoryInterface $repository,
        private AttributeRepositoryInterface $attributeRepository,
        private AttributeValueHydrator $hydrator,
    ) {
    }

    public function execute(RequestDtoInterface $requestDto): mixed
    {
        $attribute = $this->attributeRepository->findById($requestDto->attributeId);
        //TODO: Factory
        if ($attribute === null) {
            throw new EntityNotFoundException();
        }

        $attributeValue = new AttributeValue();
        $attributeValue->setOrder($this->repository->getMaxOrder() + 1);
        $attributeValue->setAttribute($attribute);


        $this->hydrator->hydrate($requestDto, $attributeValue);
        $this->repository->save($attributeValue);

        return (new IdResponse($attributeValue->getId()))->toArray();
    }
}
