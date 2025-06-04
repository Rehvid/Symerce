<?php

declare(strict_types=1);

namespace App\Product\Application\Factory;

use App\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Common\Domain\Entity\Attribute;
use App\Common\Domain\Entity\AttributeValue;
use App\Product\Application\Dto\ProductAttributeData;
use function Symfony\Component\Translation\t;

final readonly class ProductAttributeDataFactory
{
    public function __construct(
        private AttributeRepositoryInterface $attributeRepository
    ) {}

    /**
     * @param array<string, mixed> $attributes
     * @return ProductAttributeData[]
     */
    public function createFromArray(array $attributes): array
    {
        $attributeIds = $this->extractAttributeIds($attributes);
        $attributeEntitiesById = $this->fetchAttributeEntitiesByIds($attributeIds);

        return $this->mapAttributesToProductAttributeData($attributes, $attributeEntitiesById);
    }

    /**
     * @param array<string, mixed> $attributes
     * @return int[]
     */
    private function extractAttributeIds(array $attributes): array
    {
        return array_map(
            fn(string $key) => (int) str_replace('attribute_', '', $key),
            array_keys($attributes)
        );
    }

    /**
     * @param int[] $attributeIds
     * @return array<int, Attribute>
     */
    private function fetchAttributeEntitiesByIds(array $attributeIds): array
    {
        $entities = $this->attributeRepository->findBy(['id' => $attributeIds]);

        $result = [];
        foreach ($entities as $entity) {
            $result[$entity->getId()] = $entity;
        }
        return $result;
    }

    /**
     * @param array<string, mixed> $attributes
     * @param array<int, Attribute> $attributeEntitiesById
     * @return ProductAttributeData[]
     */
    private function mapAttributesToProductAttributeData(array $attributes, array $attributeEntitiesById): array
    {
        $result = [];

        foreach ($attributes as $key => $item) {
            if (!$this->isValidAttributeItem($item)) {
                continue;
            }

            $attributeId = (int) str_replace('attribute_', '', $key);
            $attribute = $attributeEntitiesById[$attributeId] ?? null;

            if ($attribute === null) {
                continue;
            }

            $isCustom = (bool) $item['isCustom'];
            $values = $item['value'];

            if ($isCustom) {
                foreach ($values as $value) {
                    $result[] = $this->createProductAttributeData($attribute, $value, true);
                }
                continue;
            }

            foreach ($attribute->getValues() as $value) {
                if (in_array($value->getId(), $values, true)) {
                    $result[] = $this->createProductAttributeData($attribute, $value, false);
                }
            }
        }

        return $result;
    }

    private function createProductAttributeData(
        Attribute $attribute,
        AttributeValue|string $value,
        bool $isCustom
    ): ProductAttributeData {
        return new ProductAttributeData(
            attribute: $attribute,
            value: $value,
            isCustom: $isCustom
        );
    }


    private function isValidAttributeItem(mixed $item): bool
    {
        return is_array($item)
            && array_key_exists('value', $item)
            && !empty($item['value'])
            && array_key_exists('isCustom', $item);
    }
}
