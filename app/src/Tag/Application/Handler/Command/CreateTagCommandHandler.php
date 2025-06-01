<?php

declare(strict_types=1);

namespace App\Tag\Application\Handler\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Tag\Application\Command\CreateTagCommand;
use App\Tag\Application\Hydrator\TagHydrator;
use App\Tag\Domain\Repository\TagRepositoryInterface;

final readonly class CreateTagCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private TagHydrator $hydrator,
        private TagRepositoryInterface $repository
    ) {}

    public function __invoke(CreateTagCommand $command): IdResponse
    {
        $tag = $this->hydrator->hydrate($command->data);
        $tag->setPosition($this->repository->getMaxPosition() + 1);

        $this->repository->save($tag);

        return new IdResponse($tag->getId());
    }
}
