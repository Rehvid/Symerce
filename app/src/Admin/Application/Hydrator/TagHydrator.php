<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Application\DTO\Request\Tag\SaveTagRequest;
use App\Entity\Tag;

final readonly class TagHydrator
{
    public function hydrate(SaveTagRequest $request, Tag $tag): Tag
    {
        $tag->setName($request->name);

        return $tag;
    }
}
