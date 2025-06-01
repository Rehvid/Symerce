<?php

declare(strict_types=1);

namespace App\Tag\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Common\Domain\Entity\Tag;
use App\Tag\Application\Dto\Response\TagFormResponse;
use App\Tag\Application\Dto\Response\TagListResponse;

final readonly class TagAssembler
{
    public function __construct(
      private ResponseHelperAssembler $responseHelperAssembler
    ) {
    }

    public function toListResponse(array $paginatedData): array
    {
        $tagListCollection = array_map(fn (Tag $tag) => $this->createTagListResponse($tag), $paginatedData);

        return $this->responseHelperAssembler->wrapListWithAdditionalData($tagListCollection);
    }

    public function toFormDataResponse(Tag $tag): array
    {
        return $this->responseHelperAssembler->wrapFormResponse(
            new TagFormResponse(
                name: $tag->getName(),
                isActive: $tag->isActive(),
                backgroundColor: $tag->getBackgroundColor(),
                textColor: $tag->getTextColor(),
            ),
        );
    }

    private function createTagListResponse(Tag $tag): TagListResponse
    {
        return new TagListResponse(
            id: $tag->getId(),
            name: $tag->getName(),
            isActive: $tag->isActive(),
        );
    }
}
