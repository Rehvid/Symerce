<?php

declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Response\Attribute\AttributeFormResponseDTO;
use App\DTO\Response\Attribute\AttributeIndexResponseDTO;
use App\DTO\Response\ResponseInterfaceData;
use App\Entity\Attribute;
use App\Mapper\Helper\ResponseMapperHelper;
use App\Mapper\Interfaces\ResponseMapperInterface;

final readonly class AttributeResponseMapper implements ResponseMapperInterface
{
    public function __construct(
        private ResponseMapperHelper $responseMapperHelper,
    ) {

    }

    public function mapToIndexResponse(array $data = []): array
    {
        return $this->responseMapperHelper->prepareIndexFormDataResponse(
            array_map(fn (Attribute $attribute) => $this->createAttributeIndexResponse($attribute), $data)
        );
    }

    private function createAttributeIndexResponse(Attribute $attribute): ResponseInterfaceData
    {
        return AttributeIndexResponseDTO::fromArray([
            'id' => $attribute->getId(),
            'name' => $attribute->getName(),
        ]);
    }

    public function mapToUpdateFormDataResponse(array $data = []): array
    {
        /** @var Attribute $attribute */
        $attribute = $data['entity'];

        $response = AttributeFormResponseDTO::fromArray([
            'name' => $attribute->getName(),
        ]);

        return $this->responseMapperHelper->prepareFormDataResponse($response);
    }
}
