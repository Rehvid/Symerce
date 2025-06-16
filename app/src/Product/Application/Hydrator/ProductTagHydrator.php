<?php

declare(strict_types=1);

namespace App\Product\Application\Hydrator;

use App\Common\Domain\Entity\Product;
use App\Common\Domain\Entity\Tag;

final readonly class ProductTagHydrator
{
    /** @param Tag[] $tags */
    public function hydrate(array $tags, Product $product): void
    {
        $product->getTags()->clear();

        foreach ($tags as $tag) {
            $product->addTag($tag);
        }
    }
}
