<?php

declare(strict_types=1);

namespace App\Tag\Application\Hydrator;

use App\Admin\Domain\Entity\Tag;
use App\Tag\Application\Dto\Request\SaveTagRequest;
use App\Tag\Application\Dto\TagData;

final readonly class TagHydrator
{
    public function hydrate(TagData $data, ?Tag $tag = null): Tag
    {
        $tag ??= new Tag();
        $tag->setName($data->name);
        $tag->setBackgroundColor($data->backgroundColor);
        $tag->setTextColor($data->textColor);
        $tag->setActive($data->isActive);

        return $tag;
    }
}
