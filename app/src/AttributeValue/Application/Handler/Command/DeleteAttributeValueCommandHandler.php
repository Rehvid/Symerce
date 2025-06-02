<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Handler\Command;

use App\AttributeValue\Application\Command\DeleteAttributeValueCommand;
use App\AttributeValue\Domain\Repository\AttributeValueRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final readonly class DeleteAttributeValueCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AttributeValueRepositoryInterface $repository,
    ) {}

    public function __invoke(DeleteAttributeValueCommand $command): void
    {
        $this->repository->remove(
            $this->repository->findById($command->attributeValueId)
        );
    }
}
