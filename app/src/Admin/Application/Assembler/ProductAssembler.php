<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\Product\ProductCreateFormResponse;
use App\Admin\Application\DTO\Response\Product\ProductFormResponse;
use App\Admin\Application\DTO\Response\Product\ProductImageResponse;
use App\Admin\Application\DTO\Response\Product\ProductListResponse;
use App\Admin\Domain\Entity\Attribute;
use App\Admin\Domain\Entity\AttributeValue;
use App\Admin\Domain\Entity\Category;
use App\Admin\Domain\Entity\DeliveryTime;
use App\Admin\Domain\Entity\Product;
use App\Admin\Domain\Entity\ProductImage;
use App\Admin\Domain\Entity\Tag;
use App\Admin\Domain\Entity\Vendor;
use App\Admin\Domain\Enums\ReductionType;
use App\Admin\Domain\Repository\AttributeRepositoryInterface;
use App\Admin\Domain\Repository\CategoryRepositoryInterface;
use App\Admin\Domain\Repository\DeliveryTimeRepositoryInterface;
use App\Admin\Domain\Repository\TagRepositoryInterface;
use App\Admin\Domain\Repository\VendorRepositoryInterface;
use App\Admin\Infrastructure\Utils\ArrayUtils;
use App\Shared\Application\Factory\MoneyFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class ProductAssembler
{
    public function __construct(
        private MoneyFactory $moneyFactory,
        private UrlGeneratorInterface $urlGenerator,
        private ResponseHelperAssembler $responseHelperAssembler,
        private CategoryRepositoryInterface $categoryRepository,
        private VendorRepositoryInterface $vendorRepository,
        private TagRepositoryInterface $tagRepository,
        private DeliveryTimeRepositoryInterface $deliveryTimeRepository,
        private AttributeRepositoryInterface $attributeRepository,
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

        return $this->responseHelperAssembler->wrapAsFormData(
            new ProductCreateFormResponse(
                ...$this->getOptions()
            ),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toFormDataResponse(Product $product): array
    {
        $discountPrice = $product->getDiscountPrice()
            ? $this->moneyFactory->create($product->getDiscountPrice())->getFormattedAmount()
            : '0';

        $promotion = $product->getPromotions()->first();
        $stock = $product->getStock();

        $response = new ProductFormResponse(
             ...$this->getOptions(),
            name: $product->getName(),
            slug: $product->getSlug(),
            description: $product->getDescription(),
            regularPrice: $this->moneyFactory->create($product->getRegularPrice())->getFormattedAmount(),
            discountPrice: $discountPrice,
            quantity: $product->getQuantity(),
            isActive: $product->isActive(),
            deliveryTime: (string) $product->getDeliveryTime()?->getId(),
            vendor: (string) $product->getVendor()?->getId(),
            tags: $product->getTags()->map(fn (Tag $tag) => (string) $tag->getId())->toArray(),
            categories: $product->getCategories()->map(fn (Category $category) => $category->getId())->toArray(),
            attributes: $this->getAttributesForFormDataResponse($product),
            images: $product->getImages()->map(
                fn (ProductImage $productImage) => $this->createProductImageResponse($productImage)
            )->toArray(),
            promotionIsActive: $promotion && $promotion->isActive(),
            promotionReduction: $promotion ? $promotion->getReduction() : null,
            promotionReductionType: $promotion ? $promotion->getType()->value : null,
            promotionDateRange: $promotion ? [$promotion->getStartsAt(), $promotion->getEndsAt()] : [],
            stockAvailableQuantity: $stock->getAvailableQuantity(),
            stockLowStockThreshold: $stock->getLowStockThreshold(),
            stockMaximumStockLevel: $stock->getMaximumStockLevel(),
            stockNotifyOnLowStock: $stock->isNotifyOnLowStock(),
            stockVisibleInStore: $stock->isVisibleInStore(),
            stockEan13: $stock->getEan13(),
            stockSku: $stock->getSku(),
         );


         return $this->responseHelperAssembler->wrapAsFormData($response);
    }

    private function getAttributesForFormDataResponse(Product $product): array
    {
        $productAttributes = [];
        $product->getAttributeValues()->map(function (AttributeValue $attributeValue) use (&$productAttributes) {
            $attributeId = $attributeValue->getAttribute()->getId();
            $index = 'attribute_'.$attributeId;

            $productAttributes[$index][] = (string) $attributeValue->getId();

            return $productAttributes;
        })->toArray();

        return $productAttributes;
    }

    private function createProductImageResponse(ProductImage $productImage): ProductImageResponse
    {
        $file = $productImage->getFile();

        return new ProductImageResponse(
            id: $file->getId(),
            name: $file->getOriginalName(),
            preview: $this->responseHelperAssembler->buildPublicFilePath($file->getPath()),
            isThumbnail: $productImage->isThumbnail(),
        );
    }

    private function createProductListResponse(Product $product): ProductListResponse
    {
        $image = null === $product->getThumbnailImage()
            ? null
            : $this->responseHelperAssembler->buildPublicFilePath($product->getThumbnailImage()->getFile()->getPath());

        $discountPrice = $this->moneyFactory->create($product->getDiscountPrice() ?? '0');

        return new ProductListResponse(
            id: $product->getId(),
            name: $product->getName(),
            image: $image,
            discountedPrice: $discountPrice,
            regularPrice: $this->moneyFactory->create($product->getRegularPrice()),
            isActive: $product->isActive(),
            quantity: $product->getQuantity(),
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

        return ArrayUtils::buildSelectedOptions(
            $deliveryTimes,
            fn (DeliveryTime $deliveryTime) => $deliveryTime->getLabel(),
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
                fn (AttributeValue $attributeValue) => (string) $attributeValue->getId(),
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
            fn (ReductionType $reductionType) => $reductionType->value,
            fn (ReductionType $reductionType) => $reductionType->value,
        );
    }
}
