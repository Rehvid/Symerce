<?php

declare(strict_types=1);

namespace App\Attribute\Application\Handler\Command;

use App\Attribute\Application\Command\DeleteAttributeCommand;
use App\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Domain\Entity\Attribute;
use App\Common\Domain\Exception\EntityNotFoundException;

final readonly class DeleteAttributeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AttributeRepositoryInterface $repository,
    ) {
    }

    public function __invoke(DeleteAttributeCommand $command): void
    {
        $attribute = $this->repository->findById($command->attributeId);
        if (null === $attribute) {
            throw EntityNotFoundException::for(Attribute::class, $command->attributeId);
        }

        $this->repository->remove($attribute);
    }
}
