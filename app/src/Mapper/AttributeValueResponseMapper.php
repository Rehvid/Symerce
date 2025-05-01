<?php

declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Response\AttributeValue\AttributeValueFormResponseDTO;
use App\DTO\Response\AttributeValue\AttributeValueIndexResponseDTO;
use App\DTO\Response\ResponseInterfaceData;
use App\Entity\AttributeValue;
use App\Mapper\Helper\ResponseMapperHelper;
use App\Mapper\Interfaces\ResponseMapperInterface;

final readonly class AttributeValueResponseMapper implements ResponseMapperInterface
{
    public function __construct(
        private ResponseMapperHelper $responseMapperHelper,
    ) {

    }

    public function mapToIndexResponse(array $data = []): array
    {
        return $this->responseMapperHelper->prepareIndexFormDataResponse(
            array_map(fn (AttributeValue $attributeValue) => $this->createAttributeValueIndex($attributeValue), $data)
        );
    }

    private function createAttributeValueIndex(AttributeValue $attributeValue): ResponseInterfaceData
    {
        return AttributeValueIndexResponseDTO::fromArray([
            'id' => $attributeValue->getId(),
            'value' => $attributeValue->getValue(),
        ]);
    }

    public function mapToUpdateFormDataResponse(array $data = []): array
    {
        /** @var AttributeValue $attributeValue */
        $attributeValue = $data['attributeValue'];

        $response = AttributeValueFormResponseDTO::fromArray([
            'value' => $attributeValue->getValue(),
        ]);

        return $this->responseMapperHelper->prepareFormDataResponse($response);
    }
}
