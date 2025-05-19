<?php

declare(strict_types=1);

namespace App\Mapper\Admin;

use App\Admin\Application\DTO\Response\Product\ProductCreateFormResponse;
use App\Admin\Application\DTO\Response\Product\ProductFormResponse;
use App\Admin\Application\DTO\Response\Product\ProductImageResponse;
use App\Admin\Application\DTO\Response\Product\ProductListResponse;
use App\DTO\Admin\Response\ResponseInterfaceData;
use App\Entity\Attribute;
use App\Entity\AttributeValue;
use App\Entity\Category;
use App\Entity\Currency;
use App\Entity\DeliveryTime;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Entity\Tag;
use App\Entity\Vendor;
use App\Mapper\Helper\ResponseMapperHelper;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Service\SettingManager;
use App\Utils\Utils;
use App\ValueObject\Money;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class ProductResponseMapper implements ResponseMapperInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SettingManager $settingManager,
        private ResponseMapperHelper $responseMapperHelper,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    /**
     * @param array<int, mixed> $data
     *
     * @return array<int, mixed>
     */
    public function mapToIndexResponse(array $data = []): array
    {
        $currency = $this->settingManager->findDefaultCurrency();

        return $this->responseMapperHelper->prepareIndexFormDataResponse(
            array_map(fn (Product $product) => $this->createProductIndexResponse($product, $currency), $data)
        );
    }

    private function createProductIndexResponse(Product $product, Currency $currency): ResponseInterfaceData
    {
        $productName = $product->getName();
        $image = null === $product->getThumbnailImage()
            ? null
            : $this->responseMapperHelper->buildPublicFilePath($product->getThumbnailImage()->getFile()->getPath());

        return ProductListResponse::fromArray([
            'id' => $product->getId(),
            'image' => $image,
            'name' => $productName,
            'discountedPrice' => new Money($this->getDiscountPrice($product), $currency),
            'regularPrice' => new Money($product->getRegularPrice(), $currency),
            'isActive' => $product->isActive(),
            'quantity' => $product->getQuantity(),
            'showUrl' => $this->urlGenerator->generate('shop.product_show', [
                'slug' => $product->getSlug(),
                'slugCategory' => $product->getCategories()->first()->getSlug(),
            ]),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function mapToStoreFormDataResponse(): array
    {
        return $this->responseMapperHelper->prepareFormDataResponse(
            ProductCreateFormResponse::fromArray($this->getOptions())
        );
    }

    public function mapToUpdateFormDataResponse(array $data = []): array
    {
        /** @var Product $product */
        $product = $data['entity'];

        $productAttributes = [];
        $product->getAttributeValues()->map(function (AttributeValue $attributeValue) use (&$productAttributes) {
            $attributeId = $attributeValue->getAttribute()->getId();
            $index = 'attribute_'.$attributeId;

            $productAttributes[$index][] = (string) $attributeValue->getId();

            return $productAttributes;
        })->toArray();

        $currency = $this->settingManager->findDefaultCurrency();

        $discountPrice = null === $product->getDiscountPrice()
            ? null
            : (new Money($this->getDiscountPrice($product), $currency))->getFormattedAmount()
        ;

        $response =  ProductFormResponse::fromArray([
            ...$this->getOptions(),
            'name' => $product->getName(),
            'slug' => $product->getSlug(),
            'description' => $product->getDescription(),
            'regularPrice' => (new Money($product->getRegularPrice(), $currency))->getFormattedAmount(),
            'discountPrice' => $discountPrice,
            'quantity' => $product->getQuantity(),
            'isActive' => $product->isActive(),
            'vendor' => (string) $product->getVendor()?->getId(),
            'tags' => $product->getTags()->map(fn (Tag $tag) => (string) $tag->getId())->toArray(),
            'deliveryTime' => (string) $product->getDeliveryTime()?->getId(),
            'categories' => $product->getCategories()->map(fn (Category $category) => (string) $category->getId())->toArray(),
            'attributes' => $productAttributes,
            'images' => $product->getImages()->map(function (ProductImage $productImage) {
                $file = $productImage->getFile();

                return ProductImageResponse::fromArray([
                    'id' => $file->getId(),
                    'name' => $file->getOriginalName(),
                    'preview' => $this->responseMapperHelper->buildPublicFilePath($file->getPath()),
                    'isThumbnail' => $productImage->isThumbnail(),
                ]);
            })->toArray(),
        ]);

        return $this->responseMapperHelper->prepareFormDataResponse($response);
    }

    /**
     * @return array<string, mixed>
     */
    private function getOptions(): array
    {
        return [
            'optionCategories' => $this->getCategories(),
            'optionVendors' => $this->getVendors(),
            'optionTags' => $this->getTags(),
            'optionDeliveryTimes' => $this->getDeliveryTimes(),
            'optionAttributes' => $this->getAttributes(),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    private function getCategories(): array
    {
        /** @var Category[] $categories */
        $categories = $this->entityManager->getRepository(Category::class)->findAll();

        return Utils::buildSelectedOptions(
            $categories,
            fn (Category $category) => $category->getName(),
            fn (Category $category) => (string) $category->getId(),
        );
    }

    /**
     * @return array<int, mixed>
     */
    private function getVendors(): array
    {
        /** @var Vendor[] $vendors */
        $vendors = $this->entityManager->getRepository(Vendor::class)->findAll();

        return Utils::buildSelectedOptions(
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
        $tags = $this->entityManager->getRepository(Tag::class)->findAll();

        return Utils::buildSelectedOptions(
            $tags,
            fn ($tag) => $tag->getName(),
            fn (Tag $tag) => (string) $tag->getId(),
        );
    }

    /**
     * @return array<int, mixed>
     */
    private function getDeliveryTimes(): array
    {
        /** @var DeliveryTime[] $deliveryTimes */
        $deliveryTimes = $this->entityManager->getRepository(DeliveryTime::class)->findAll();

        return Utils::buildSelectedOptions(
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
        $attributes = $this->entityManager->getRepository(Attribute::class)->findAll();

        $data = [];
        foreach ($attributes as $key => $attribute) {
            $data[$key]['options'] = Utils::buildSelectedOptions(
                $attribute->getValues()->toArray(),
                fn (AttributeValue $attributeValue) => $attributeValue->getValue(),
                fn (AttributeValue $attributeValue) => (string) $attributeValue->getId(),
            );
            $data[$key]['label'] = $attribute->getName();
            $data[$key]['name'] = 'attribute_'.$attribute->getId();
        }

        return $data;
    }

    private function getDiscountPrice(Product $product): string
    {
        return null === $product->getDiscountPrice() ? '0' : $product->getDiscountPrice();
    }
}
