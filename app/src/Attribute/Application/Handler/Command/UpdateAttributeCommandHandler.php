<?php

declare(strict_types=1);

namespace App\Attribute\Application\Handler\Command;

use App\Attribute\Application\Command\UpdateAttributeCommand;
use App\Attribute\Application\Hydrator\AttributeHydrator;
use App\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Common\Domain\Entity\Attribute;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;

final readonly class UpdateAttributeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AttributeRepositoryInterface $repository,
        private AttributeHydrator $hydrator,
    ) {}

    public function __invoke(UpdateAttributeCommand $command): IdResponse
    {
        /** @var ?Attribute $attribute */
        $attribute = $this->repository->findById($command->attributeId);
        if (null === $attribute) {
            throw EntityNotFoundException::for(Attribute::class, $command->attributeId);
        }

        $attribute = $this->hydrator->hydrate($command->data, $attribute);

        $this->repository->save($attribute);

        return new IdResponse($attribute->getId());
    }
}
