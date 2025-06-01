<?php

declare(strict_types=1);

namespace App\Tag\Application\Handler\Query;

use App\Admin\Domain\Entity\Tag;
use App\Shared\Application\Query\QueryHandlerInterface;
use App\Shared\Domain\Exception\EntityNotFoundException;
use App\Tag\Application\Assembler\TagAssembler;
use App\Tag\Application\Query\GetTagForEditQuery;
use App\Tag\Domain\Repository\TagRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class TagForEditQueryHandler implements QueryHandlerInterface
{

    public function __construct(
        private TagRepositoryInterface $repository,
        private TagAssembler $tagAssembler
    ) {}

    public function __invoke(GetTagForEditQuery $query): array
    {
        /** @var Tag|null $tag */
        $tag = $this->repository->findById($query->tagId);
        if (null === $tag) {
            throw EntityNotFoundException::for(Tag::class, $query->tagId);
        }

        return $this->tagAssembler->toFormDataResponse($tag);
    }
}
