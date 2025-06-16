<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Handler\Command;

use App\AttributeValue\Application\Command\CreateAttributeValueCommand;
use App\AttributeValue\Application\Hydrator\AttributeValueHydrator;
use App\AttributeValue\Domain\Repository\AttributeValueRepositoryInterface;
use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Domain\Entity\AttributeValue;

final readonly class CreateAttributeValueCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AttributeValueRepositoryInterface $repository,
        private AttributeValueHydrator $hydrator,
    ) {
    }

    public function __invoke(CreateAttributeValueCommand $command): IdResponse
    {
        $attributeValue = $this->hydrator->hydrate($command->data, new AttributeValue());
        $attributeValue->setPosition($this->repository->getMaxPosition() + 1);

        $this->repository->save($attributeValue);

        return new IdResponse($attributeValue->getId());
    }
}
