<?php

declare(strict_types=1);

namespace App\Tag\Application\Factory;

use App\Tag\Application\Dto\Request\SaveTagRequest;
use App\Tag\Application\Dto\TagData;

final readonly class TagDataFactory
{
    public function fromRequest(SaveTagRequest $tagRequest): TagData
    {
        return new TagData(
            name: $tagRequest->name,
            isActive: $tagRequest->isActive,
            backgroundColor: $tagRequest->backgroundColor,
            textColor: $tagRequest->textColor
        );
    }
}
