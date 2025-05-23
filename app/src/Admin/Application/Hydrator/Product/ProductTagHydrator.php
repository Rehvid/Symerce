<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator\Product;

use App\Admin\Domain\Entity\Product;
use App\Admin\Domain\Entity\Tag;
use App\Admin\Domain\Repository\TagRepositoryInterface;

final readonly class ProductTagHydrator
{
    public function __construct(
       private TagRepositoryInterface $repository,
    ) {
    }

    public function hydrate(array $tagIds, Product $product): void
    {
        /** @var $tagEntities Tag[] */
        $tagEntities = $this->repository->findBy(['id' => $tagIds]);
        $product->getTags()->clear();

        foreach ($tagEntities as $tag) {
            $product->addTag($tag);
        }
    }
}
