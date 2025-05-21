<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Attribute;

use App\Admin\Application\Hydrator\AttributeHydrator;
use App\Admin\Domain\Entity\Attribute;
use App\Admin\Domain\Repository\AttributeRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;

final readonly class CreateAttributeUseCase implements CreateUseCaseInterface
{
    public function __construct(
       private AttributeRepositoryInterface $repository,
       private AttributeHydrator $hydrator,
    ) {
    }

    public function execute(RequestDtoInterface $requestDto): mixed
    {
        $attribute = new Attribute();
        $attribute->setOrder($this->repository->getMaxOrder() + 1);

        $this->hydrator->hydrate($requestDto, $attribute);
        $this->repository->save($attribute);

        return (new IdResponse($attribute->getId()))->toArray();
    }
}
