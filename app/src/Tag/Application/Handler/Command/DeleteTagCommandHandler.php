<?php

declare(strict_types=1);

namespace App\Tag\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Domain\Entity\Tag;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Tag\Application\Command\DeleteTagCommand;
use App\Tag\Domain\Repository\TagRepositoryInterface;

final readonly class DeleteTagCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private TagRepositoryInterface $repository
    ) {}

    public function __invoke(DeleteTagCommand $command): void
    {
        /** @var ?Tag $tag */
        $tag = $this->repository->findById($command->tagId);

        if (null === $tag) {
            throw EntityNotFoundException::for(Tag::class, $command->tagId);
        }

        $this->repository->remove($tag);
    }
}
