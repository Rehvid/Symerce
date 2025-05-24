<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\Tag\TagFormResponse;
use App\Admin\Application\DTO\Response\Tag\TagListResponse;
use App\Admin\Domain\Entity\Tag;

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
            ),
        );
    }

    private function createTagListResponse(Tag $tag): TagListResponse
    {
        return new TagListResponse(
            id: $tag->getId(),
            name: $tag->getName(),
        );
    }
}
