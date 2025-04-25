<?php

declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Response\Product\ProductFormResponseDTO;
use App\DTO\Response\Product\ProductImageResponseDTO;
use App\DTO\Response\Product\ProductIndexResponseDTO;
use App\DTO\Response\Product\ProductUpdateFormResponseDTO;
use App\DTO\Response\ResponseInterfaceData;
use App\Entity\Attribute;
use App\Entity\AttributeValue;
use App\Entity\Category;
use App\Entity\DeliveryTime;
use App\Entity\File;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Entity\Tag;
use App\Entity\Vendor;
use App\Service\FileService;
use App\Service\SettingManager;
use App\Utils\Utils;
use App\ValueObject\Money;
use Doctrine\ORM\EntityManagerInterface;

final readonly class ProductMapper
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SettingManager $settingManager,
        private FileService $fileService,
    )
    {
    }

    public function mapToIndex(array $data): array
    {
        $currency = $this->settingManager->findDefaultCurrency();
        return array_map(function (Product $product) use ($currency) {
            $productName = $product->getName();
            $image = $product->getThumbnailImage() === null
                ? null
                : $this->fileService->preparePublicPathToFile($product->getThumbnailImage()->getFile()->getPath());

              return ProductIndexResponseDTO::fromArray([
                  'id' => $product->getId(),
                  'image' => $image,
                  'name' => $productName,
                  'discountedPrice' => new Money($product->getDiscountPrice(), $currency),
                  'regularPrice' => new Money($product->getRegularPrice(), $currency),
                  'isActive' => $product->isActive(),
                  'quantity' => $product->getQuantity(),
              ]);
        }, $data);
    }

    public function mapToStoreFormData(): ResponseInterfaceData|ProductFormResponseDTO
    {
        return ProductFormResponseDTO::fromArray($this->getOptions());
    }

    public function mapToUpdateFormData(Product $product): ResponseInterfaceData
    {
        $productAttributes = [];
        $product->getAttributeValues()->map(function (AttributeValue $attributeValue) use (&$productAttributes) {
            $attributeId = $attributeValue->getAttribute()->getId();
            $index = 'attribute_' . $attributeId;

            $productAttributes[$index][] = (string) $attributeValue->getId();

            return $productAttributes;
        })->toArray();

        $currency = $this->settingManager->findDefaultCurrency();

        return ProductUpdateFormResponseDTO::fromArray([
            ...$this->getOptions(),
            'name' => $product->getName(),
            'slug' => $product->getSlug(),
            'description' => $product->getDescription(),
            'regularPrice' => (new Money($product->getRegularPrice(), $currency))->getFormattedAmount(),
            'discountPrice' => (new Money($product->getDiscountPrice(), $currency))->getFormattedAmount(),
            'quantity' => $product->getQuantity(),
            'isActive' => $product->isActive(),
            'vendor' => (string) $product->getVendor()?->getId(),
            'tags' => $product->getTags()->map(fn (Tag $tag) => (string) $tag->getId())->toArray(),
            'deliveryTimes' => $product->getDeliveryTimes()->map(fn (DeliveryTime $deliveryTime) => (string) $deliveryTime->getId())->toArray(),
            'categories' => $product->getCategories()->map(fn (Category $category) => (string) $category->getId())->toArray(),
            'attributes' => $productAttributes,
            'images' => $product->getImages()->map(function (ProductImage $productImage) {
                $file = $productImage->getFile();
                return ProductImageResponseDTO::fromArray([
                    'id' => $file->getId(),
                    'name' => $file->getOriginalName(),
                    'preview' => $this->fileService->preparePublicPathToFile($file->getPath()),
                    'isThumbnail' => $productImage->isThumbnail()
                ]);
            })->toArray(),
        ]);
    }

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

    private function getCategories(): array
    {
        $categories = $this->entityManager->getRepository(Category::class)->findAll();

        return Utils::buildSelectedOptions(
            $categories,
            fn (Category $category) => $category->getName(),
            fn (Category $category) => (string) $category->getId(),
        );
    }

    private function getVendors(): array
    {
        $vendors = $this->entityManager->getRepository(Vendor::class)->findAll();

        return Utils::buildSelectedOptions(
            $vendors,
            fn (Vendor $vendor) => $vendor->getName(),
            fn (Vendor $vendor) => (string) $vendor->getId(),
        );
    }

    private function getTags(): array
    {
        $tags = $this->entityManager->getRepository(Tag::class)->findAll();

        return Utils::buildSelectedOptions(
            $tags,
            fn ($tag) => $tag->getName(),
            fn (Tag $tag) => (string) $tag->getId(),
        );
    }

    private function getDeliveryTimes(): array
    {
        $deliveryTimes = $this->entityManager->getRepository(DeliveryTime::class)->findAll();

        return Utils::buildSelectedOptions(
            $deliveryTimes,
            fn (DeliveryTime $deliveryTime) => $deliveryTime->getLabel(),
            fn (DeliveryTime $deliveryTime) => (string) $deliveryTime->getId(),
        );
    }

    private function getAttributes(): array
    {
        $attributes = $this->entityManager->getRepository(Attribute::class)->findAll();

        $data = [];
        /** @var Attribute $attribute */
        foreach ($attributes as $key => $attribute) {
            $data[$key]['options'] = Utils::buildSelectedOptions(
                $attribute->getValues()->toArray(),
                fn (AttributeValue $attributeValue) => $attributeValue->getValue(),
                fn (AttributeValue $attributeValue) => (string) $attributeValue->getId(),
            );
            $data[$key]['label'] = $attribute->getName();
            $data[$key]['name'] = "attribute_" . $attribute->getId();
        }

        return $data;
    }
}
