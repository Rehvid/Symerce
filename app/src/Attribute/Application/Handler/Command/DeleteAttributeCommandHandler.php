<?php

declare(strict_types=1);

namespace App\Attribute\Application\Handler\Command;

use App\Attribute\Application\Command\DeleteAttributeCommand;
use App\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final readonly class DeleteAttributeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AttributeRepositoryInterface $repository,
    ) {}

    public function __invoke(DeleteAttributeCommand $command): void
    {
        //TODO: Later
        $this->repository->remove(
            $this->repository->findById($command->attributeId),
        );
    }
}
