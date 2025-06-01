<?php

declare (strict_types=1);

namespace App\Tag\Application\Handler\Command;

use App\Admin\Domain\Entity\Tag;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Domain\Exception\EntityNotFoundException;
use App\Tag\Application\Command\UpdateTagCommand;
use App\Tag\Application\Hydrator\TagHydrator;
use App\Tag\Domain\Repository\TagRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class UpdateTagCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private TagHydrator $hydrator,
        private TagRepositoryInterface $repository
    ) {}

    public function __invoke(UpdateTagCommand $command): IdResponse
    {
        /** @var ?Tag $tag */
        $tag = $this->repository->findById($command->tagId);

        if (null === $tag) {
            throw EntityNotFoundException::for(Tag::class, $command->tagId);
        }

        $tag = $this->hydrator->hydrate($command->data, $tag);

        $this->repository->save($tag);

        return new IdResponse($tag->getId());
    }
}
