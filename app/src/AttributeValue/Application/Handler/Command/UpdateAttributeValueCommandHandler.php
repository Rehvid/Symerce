<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Handler\Command;

use App\AttributeValue\Application\Command\UpdateAttributeValueCommand;
use App\AttributeValue\Application\Hydrator\AttributeValueHydrator;
use App\AttributeValue\Domain\Repository\AttributeValueRepositoryInterface;
use App\Common\Domain\Entity\AttributeValue;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;

final readonly class UpdateAttributeValueCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AttributeValueRepositoryInterface $repository,
        private AttributeValueHydrator $hydrator,
    ) {}

    public function __invoke(UpdateAttributeValueCommand $command): IdResponse
    {
        /** @var ?AttributeValue $attributeValue */
        $attributeValue = $this->repository->findById($command->attributeValueId);
        if (null === $attributeValue) {
            throw EntityNotFoundException::for(AttributeValue::class, $command->attributeValueId);
        }

        $attributeValue = $this->hydrator->hydrate($command->data, $attributeValue);

        $this->repository->save($attributeValue);

        return new IdResponse($attributeValue->getId());
    }
}
