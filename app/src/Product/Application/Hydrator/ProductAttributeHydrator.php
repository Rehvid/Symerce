<?php

declare(strict_types=1);

namespace App\Product\Application\Hydrator;

use App\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Common\Domain\Entity\AttributeValue;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Entity\ProductAttribute;
use App\Product\Application\Dto\ProductAttributeData;
use Doctrine\ORM\EntityManagerInterface;

final readonly class ProductAttributeHydrator
{
    /** @param ProductAttributeData[] $attributes */
    public function hydrate(array $attributes, Product $product): void
    {
        $product->getAttributes()->clear();

        foreach ($attributes as $attribute) {
            $product->addProductAttribute($this->createProductAttribute($attribute, $product));
        }
    }

    private function createProductAttribute(ProductAttributeData $data, Product $product): ProductAttribute
    {
        $productAttribute = new ProductAttribute();
        $productAttribute->setAttribute($data->attribute);
        $productAttribute->setProduct($product);
        if ($data->isCustom) {
            $productAttribute->setCustomValue($data->value);
        } else {
            $productAttribute->setPredefinedValue($data->value);
        }

        return $productAttribute;
    }
}
