<?php

declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Response\ResponseInterfaceData;
use App\DTO\Response\Tag\TagFormResponseDTO;
use App\DTO\Response\Tag\TagIndexResponseDTO;
use App\Entity\Tag;
use App\Mapper\Helper\ResponseMapperHelper;
use App\Mapper\Interfaces\ResponseMapperInterface;

final readonly class TagResponseMapper implements ResponseMapperInterface
{
    public function __construct(
        private ResponseMapperHelper $responseMapperHelper,
    ) {
    }

    public function mapToIndexResponse(array $data = []): array
    {
        return $this->responseMapperHelper->prepareIndexFormDataResponse(
            array_map(fn (Tag $tag) => $this->createTagIndexResponse($tag), $data)
        );
    }

    private function createTagIndexResponse(Tag $tag): ResponseInterfaceData
    {
        return TagIndexResponseDTO::fromArray([
            'id' => $tag->getId(),
            'name' => $tag->getName(),
        ]);
    }

    public function mapToUpdateFormDataResponse(array $data = []): array
    {
        /** @var Tag $tag */
        $tag = $data['tag'];
        $response = TagFormResponseDTO::fromArray([
            'name' => $tag->getName(),
        ]);

        return $this->responseMapperHelper->prepareFormDataResponse($response);
    }
}
