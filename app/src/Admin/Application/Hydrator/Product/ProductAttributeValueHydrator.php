<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator\Product;

use App\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Common\Domain\Entity\AttributeValue;
use App\Common\Domain\Entity\Product;

final readonly class ProductAttributeValueHydrator
{
    public function __construct(
        private AttributeRepositoryInterface $attributeRepository,
    ) {}

    public function hydrate(array $attributeIds, Product $product): void
    {
        $attributeValues = $this->getAttributeValues($attributeIds);

        $product->getAttributeValues()->clear();

        foreach ($attributeValues as $attributeValue) {
            $product->addAttributeValue($attributeValue);
        }
    }

    /**
     * @param array<string, mixed> $attributeIds
     *
     * @return AttributeValue[]
     */
    private function getAttributeValues(array $attributeIds): array
    {
        $ids = [];

        foreach ($attributeIds as $key => $value) {
            $attributeId = str_replace('attribute_', '', $key);
            $ids[$attributeId] = $value;
        }

        if (!empty($ids)) {
            return $this->attributeRepository->getAttributeValuesByAttributes($ids);
        }

        return $ids;
    }
}
