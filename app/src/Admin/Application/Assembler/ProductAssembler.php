<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\Product\ProductFormContext;
use App\Admin\Application\DTO\Response\Product\ProductListResponse;
use App\Admin\Application\Factory\Product\ProductFormResponseFactory;
use App\Admin\Domain\Enums\ReductionType;
use App\Admin\Domain\Repository\AttributeRepositoryInterface;
use App\Admin\Domain\Repository\DeliveryTimeRepositoryInterface;
use App\Admin\Domain\Repository\VendorRepositoryInterface;
use App\Admin\Infrastructure\Utils\ArrayUtils;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Domain\Entity\Attribute;
use App\Common\Domain\Entity\AttributeValue;
use App\Common\Domain\Entity\Category;
use App\Common\Domain\Entity\DeliveryTime;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Entity\Tag;
use App\Common\Domain\Entity\Vendor;
use App\Shared\Application\Factory\MoneyFactory;
use App\Tag\Domain\Repository\TagRepositoryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class ProductAssembler
{
    public function __construct(
        private MoneyFactory $moneyFactory,
        private UrlGeneratorInterface $urlGenerator,
        private TranslatorInterface $translator,
        private ResponseHelperAssembler $responseHelperAssembler,
        private CategoryRepositoryInterface $categoryRepository,
        private VendorRepositoryInterface $vendorRepository,
        private TagRepositoryInterface $tagRepository,
        private DeliveryTimeRepositoryInterface $deliveryTimeRepository,
        private AttributeRepositoryInterface $attributeRepository,
        private ProductFormResponseFactory $productFormResponseFactory,
    ) {}

    /**
     * @param array<int, mixed> $paginatedData
     * @return array<string, mixed>
     */
    public function toListResponse(array $paginatedData): array
    {
        $productListCollection = array_map(
            fn (Product $product) => $this->createProductListResponse($product),
            $paginatedData
        );

        return $this->responseHelperAssembler->wrapListWithAdditionalData($productListCollection);
    }

    public function toCreateFormDataResponse(): array
    {
        $this->getOptions();

        return $this->responseHelperAssembler->wrapFormResponse(
            context: new ProductFormContext(
                ...$this->getOptions()
            ),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toFormDataResponse(Product $product): array
    {
        $productFormResponse = $this->productFormResponseFactory->fromProduct($product);

        $context = new ProductFormContext(
            ...$this->getOptions()
        );

         return $this->responseHelperAssembler->wrapFormResponse($productFormResponse, $context);
    }

    private function createProductListResponse(Product $product): ProductListResponse
    {
        $image = null === $product->getThumbnailImage()
            ? null
            : $this->responseHelperAssembler->buildPublicFilePath($product->getThumbnailImage()->getFile()->getPath());

        $regularPrice = $this->moneyFactory->create($product->getRegularPrice());

        $discountPrice = null;
        $promotion = $product->getPromotionForProductTab();
        if ($promotion !== null) {
            $discountPrice = $promotion->getType() === ReductionType::PERCENT
                ? $regularPrice->subtractPercentage($promotion->getReduction())
                : $regularPrice->subtract($promotion->getReduction());
        }

        return new ProductListResponse(
            id: $product->getId(),
            name: $product->getName(),
            image: $image,
            discountedPrice: $discountPrice,
            regularPrice: $this->moneyFactory->create($product->getRegularPrice()),
            isActive: $product->isActive(),
            quantity: $product->getStock()->getAvailableQuantity(),
            showUrl: $this->urlGenerator->generate('shop.product_show', [
                'slug' => $product->getSlug(),
                'slugCategory' => $product->getCategories()->first()->getSlug(),
            ]),
        );
    }


    private function getOptions(): array
    {
        return [
            'optionCategories' => $this->getCategories(),
            'optionVendors' => $this->getVendors(),
            'optionTags' => $this->getTags(),
            'optionDeliveryTimes' => $this->getDeliveryTimes(),
            'optionAttributes' => $this->getAttributes(),
            'promotionTypes' => $this->getPromotionTypes()
        ];
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
    private function getVendors(): array
    {
        /** @var Vendor[] $vendors */
        $vendors = $this->vendorRepository->findAll();

        return ArrayUtils::buildSelectedOptions(
            $vendors,
            fn (Vendor $vendor) => $vendor->getName(),
            fn (Vendor $vendor) => (string) $vendor->getId(),
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
    private function getDeliveryTimes(): array
    {
        /** @var DeliveryTime[] $deliveryTimes */
        $deliveryTimes = $this->deliveryTimeRepository->findAll();
        $workDay = $this->translator->trans('base.common.workday');

        return ArrayUtils::buildSelectedOptions(
            $deliveryTimes,
            fn (DeliveryTime $deliveryTime) => $deliveryTime->getLabel() . " ( {$deliveryTime->getMinDays()} - {$deliveryTime->getMaxDays()}  $workDay )",
            fn (DeliveryTime $deliveryTime) => (string) $deliveryTime->getId(),
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
        }

        return $data;
    }

    private function getPromotionTypes(): array
    {
        return ArrayUtils::buildSelectedOptions(
            ReductionType::cases(),
            fn (ReductionType $reductionType) => $this->translator->trans('base.reduction_type.' . $reductionType->value),
            fn (ReductionType $reductionType) => $reductionType->value,
        );
    }
}
