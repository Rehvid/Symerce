<?php

declare(strict_types=1);

namespace App\Attribute\Application\Handler\Command;

use App\Attribute\Application\Command\CreateAttributeCommand;
use App\Attribute\Application\Hydrator\AttributeHydrator;
use App\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Common\Domain\Entity\Attribute;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;

final readonly class CreateAttributeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AttributeRepositoryInterface $repository,
        private AttributeHydrator $hydrator
    ) {}

    public function __invoke(CreateAttributeCommand $command): IdResponse
    {
        $attribute = $this->hydrator->hydrate($command->data, new Attribute());

        $this->repository->save($attribute);

        return new IdResponse($attribute->getId());
    }
}
