<?php

declare(strict_types=1);

namespace App\Tag\Application\Handler\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Tag\Application\Command\DeleteTagCommand;
use App\Tag\Domain\Repository\TagRepositoryInterface;

final readonly class DeleteTagCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private TagRepositoryInterface $repository
    ) {}

    public function __invoke(DeleteTagCommand $command): void
    {
        $this->repository->remove(
            $this->repository->findById($command->tagId)
        );
    }
}
