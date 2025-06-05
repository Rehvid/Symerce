<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Handler\Command;

use App\AttributeValue\Application\Command\DeleteAttributeValueCommand;
use App\AttributeValue\Domain\Repository\AttributeValueRepositoryInterface;
use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Domain\Entity\AttributeValue;
use App\Common\Domain\Exception\EntityNotFoundException;

final readonly class DeleteAttributeValueCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AttributeValueRepositoryInterface $repository,
    ) {}

    public function __invoke(DeleteAttributeValueCommand $command): void
    {
        /** @var ?AttributeValue $attributeValue */
        $attributeValue = $this->repository->findById($command->attributeValueId);
        if (null === $attributeValue) {
            throw EntityNotFoundException::for(AttributeValue::class, $command->attributeValueId);
        }

        $this->repository->remove($attributeValue);
    }
}
