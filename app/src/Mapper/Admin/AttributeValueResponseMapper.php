<?php

declare(strict_types=1);

namespace App\Mapper\Admin;

use App\Admin\Application\DTO\Response\AttributeValue\AttributeValueFormResponse;
use App\Admin\Application\DTO\Response\AttributeValue\AttributeValueListResponse;
use App\DTO\Admin\Response\ResponseInterfaceData;
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
        return AttributeValueListResponse::fromArray([
            'id' => $attributeValue->getId(),
            'value' => $attributeValue->getValue(),
        ]);
    }

    public function mapToUpdateFormDataResponse(array $data = []): array
    {
        /** @var AttributeValue $attributeValue */
        $attributeValue = $data['entity'];

        $response = AttributeValueFormResponse::fromArray([
            'value' => $attributeValue->getValue(),
        ]);

        return $this->responseMapperHelper->prepareFormDataResponse($response);
    }
}
