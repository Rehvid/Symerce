<?php

declare(strict_types=1);

namespace App\Product\Application\Factory;

use App\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Brand\Domain\Repository\BrandRepositoryInterface;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Domain\Entity\Attribute;
use App\Common\Domain\Entity\AttributeValue;
use App\Common\Domain\Entity\Brand;
use App\Common\Domain\Entity\Category;
use App\Common\Domain\Entity\Tag;
use App\Common\Domain\Entity\Warehouse;
use App\Common\Domain\Enums\ReductionType;
use App\Common\Infrastructure\Utils\ArrayUtils;
use App\Product\Application\Dto\Response\Form\ProductFormContext;
use App\Tag\Domain\Repository\TagRepositoryInterface;
use App\Warehouse\Domain\Repository\WarehouseRepositoryInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class ProductFormContextFactory
{
    public function __construct(
        private TranslatorInterface $translator,
        private CategoryRepositoryInterface $categoryRepository,
        private BrandRepositoryInterface $brandRepository,
        private TagRepositoryInterface $tagRepository,
        private AttributeRepositoryInterface $attributeRepository,
        private WarehouseRepositoryInterface $warehouseRepository,
    ) {
    }

    public function create(): ProductFormContext
    {
        $this->getAttributes();

        return new ProductFormContext(
            availableTags: $this->getTags(),
            availableCategories: $this->getCategories(),
            availableBrands: $this->getBrands(),
            availableAttributes: $this->getAttributes(),
            availablePromotionTypes: $this->getPromotionTypes(),
            availableWarehouses: $this->getWarehouses(),
        );
    }

    /**
     * @return array<int, mixed>
     */
    private function getCategories(): array
    {
        /** @var Category[] $categories */
        $categories = $this->categoryRepository->findAll();

        return ArrayUtils::buildSelectedOptions(
            $categories,
            fn (Category $category) => $category->getName(),
            fn (Category $category) =>  $category->getId(),
        );
    }

    /**
     * @return array<int, mixed>
     */
    private function getBrands(): array
    {
        /** @var Brand[] $vendors */
        $vendors = $this->brandRepository->findAll();

        return ArrayUtils::buildSelectedOptions(
            $vendors,
            fn (Brand $brand) => $brand->getName(),
            fn (Brand $brand) => $brand->getId(),
        );
    }

    /**
     * @return array<int, mixed>
     */
    private function getTags(): array
    {
        /** @var Tag[] $tags */
        $tags = $this->tagRepository->findAll();

        return ArrayUtils::buildSelectedOptions(
            $tags,
            fn ($tag) => $tag->getName(),
            fn (Tag $tag) => $tag->getId(),
        );
    }

    /**
     * @return array<int, mixed>
     */
    private function getAttributes(): array
    {
        /** @var Attribute[] $attributes */
        $attributes = $this->attributeRepository->findAll();

        $data = [];
        foreach ($attributes as $key => $attribute) {
            $data[$key]['options'] = ArrayUtils::buildSelectedOptions(
                $attribute->getValues()->toArray(),
                fn (AttributeValue $attributeValue) => $attributeValue->getValue(),
                fn (AttributeValue $attributeValue) => $attributeValue->getId(),
            );
            $data[$key]['label'] = $attribute->getName();
            $data[$key]['name'] = 'attribute_'.$attribute->getId();
            $data[$key]['type'] = $attribute->getType()->value;
        }

        return $data;
    }

    private function getPromotionTypes(): array
    {
        return ArrayUtils::buildSelectedOptions(
            ReductionType::cases(),
            fn (ReductionType $reductionType) => $this->translator->trans('base.reduction_type.'.$reductionType->value),
            fn (ReductionType $reductionType) => $reductionType->value,
        );
    }

    private function getWarehouses(): array
    {
        return ArrayUtils::buildSelectedOptions(
            items: $this->warehouseRepository->findAll(),
            labelCallback: fn (Warehouse $warehouse) => $warehouse->getName(),
            valueCallback: fn (Warehouse $warehouse) => $warehouse->getId(),
        );
    }
}
