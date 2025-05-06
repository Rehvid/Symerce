<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler\Admin;

use App\DTO\Admin\Request\FileRequestDTO;
use App\DTO\Admin\Request\PersistableInterface;
use App\DTO\Admin\Request\Product\SaveProductRequestDTO;
use App\Entity\Attribute;
use App\Entity\AttributeValue;
use App\Entity\Category;
use App\Entity\DeliveryTime;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Entity\Tag;
use App\Entity\Vendor;
use App\Repository\AttributeRepository;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;
use App\Service\FileService;
use App\Service\SluggerService;
use App\Traits\FileRequestMapperTrait;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends BaseEntityFiller<SaveProductRequestDTO>
 */
final class ProductEntityFiller extends BaseEntityFiller
{
    use FileRequestMapperTrait;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FileService $fileService,
        private readonly SluggerService $sluggerService,
    ) {
    }

    public function toNewEntity(PersistableInterface|SaveProductRequestDTO $persistable): Product
    {
        $product = new Product();
        $product->setSlug($this->saveSlug($persistable->name, $persistable->slug));
        $product->setOrder($this->entityManager->getRepository(Product::class)->count());

        return $this->fillEntity($persistable, $product);
    }

    /**
     * @param Product $entity
     */
    public function toExistingEntity(PersistableInterface|SaveProductRequestDTO $persistable, object $entity): Product
    {
        if ($entity->getSlug() !== $persistable->slug) {
            $entity->setSlug($this->saveSlug($persistable->name, $persistable->slug));
        }

        return $this->fillEntity($persistable, $entity);
    }

    public static function supports(): string
    {
        return SaveProductRequestDTO::class;
    }

    /** @param Product $entity */
    protected function fillEntity(
        PersistableInterface|SaveProductRequestDTO $persistable,
        object $entity
    ): Product {
        $entity->setVendor($this->getVendor($persistable->vendor));
        $entity->setName($persistable->name);
        $entity->setActive($persistable->isActive);
        $entity->setDescription($persistable->description);
        $entity->setRegularPrice($persistable->regularPrice);
        $entity->setQuantity((int) $persistable->quantity);

        if (null !== $persistable->discountPrice && $persistable->discountPrice !== '') {
            $entity->setDiscountPrice($persistable->discountPrice);
        }

        $this->fillCategories($persistable, $entity);
        $this->fillAttributeValues($persistable, $entity);
        $this->fillTags($persistable, $entity);
        $this->fillDeliveryTimes($persistable, $entity);
        $this->fillImages($persistable, $entity);

        if ($persistable->thumbnail) {

            $isFound = false;

            /** @var ProductImage $productImage */
            foreach ($entity->getImages() as $productImage) {
                if (!$isFound && $productImage->getFile()->getOriginalName() === $persistable->thumbnail['name']) {
                    $productImage->setIsThumbnail(true);
                    $isFound = true;
                    continue;
                }

                $productImage->setIsThumbnail(false);
            }
        }

        if (null === $entity->getThumbnailImage() && $entity->getImages()->count() > 0) {
            $productImage = $entity->getImages()->first();
            $productImage->setIsThumbnail(true);
        }

        return $entity;
    }

    private function saveSlug(string $name, ?string $slug): string
    {
        if (null === $slug || empty(trim($slug))) {
            return $this->generateSlug($name);
        }

        return $this->generateSlug($slug);
    }

    public function generateSlug(string $name): string
    {
        return $this->sluggerService->slugifyUnique($name, Category::class, 'slug');
    }

    private function fillCategories(SaveProductRequestDTO $persistable, Product $product): void
    {
        $categories = $this->getCategories($persistable->categories);
        $product->getCategories()->clear();

        /** @var Category $category */
        foreach ($categories as $category) {
            $product->addCategory($category);
        }
    }

    /**
     * @param array<int, mixed> $categoryIds
     *
     * @return Category[]
     */
    private function getCategories(array $categoryIds): array
    {
        return $this->entityManager->getRepository(Category::class)->findBy(['id' => $categoryIds]);
    }

    private function fillDeliveryTimes(SaveProductRequestDTO $persistable, Product $product): void
    {
        $deliveryTimes = $this->getDeliveryTimes($persistable->deliveryTimes);
        $product->getDeliveryTimes()->clear();

        /** @var DeliveryTime $deliveryTime */
        foreach ($deliveryTimes as $deliveryTime) {
            $product->addDeliveryTime($deliveryTime);
        }
    }

    /**
     * @param array<int, mixed> $deliveryTimeIds
     *
     * @return DeliveryTime[]
     */
    private function getDeliveryTimes(array $deliveryTimeIds): array
    {
        return $this->entityManager->getRepository(DeliveryTime::class)->findBy(['id' => $deliveryTimeIds]);
    }

    private function fillTags(SaveProductRequestDTO $persistable, Product $product): void
    {
        $tags = $this->getTags($persistable->tags);
        $product->getTags()->clear();

        /** @var Tag $tag */
        foreach ($tags as $tag) {
            $product->addTag($tag);
        }
    }

    /**
     * @param array<int,mixed> $tagIds
     *
     * @return Tag[]
     */
    private function getTags(array $tagIds): array
    {
        return $this->entityManager->getRepository(Tag::class)->findBy(['id' => $tagIds]);
    }

    private function fillAttributeValues(SaveProductRequestDTO $persistable, Product $product): void
    {
        $attributes = $this->getAttributes($persistable->attributes);


        $product->getAttributeValues()->clear();

        /** @var AttributeValue $attribute */
        foreach ($attributes as $attribute) {
            $product->addAttributeValue($attribute);
        }
    }

    /**
     * @param array<string, mixed> $attributeIds
     *
     * @return array<int,mixed>
     */
    private function getAttributes(array $attributeIds): array
    {
        $ids = [];
        foreach ($attributeIds as $key => $value) {
            $attributeId = str_replace('attribute_', '', $key);
            $ids[$attributeId] = $value;
        }

        if (!empty($ids)) {
            /** @var AttributeRepository $attributeRepository */
            $attributeRepository = $this->entityManager->getRepository(Attribute::class);

            return $attributeRepository->getAttributeValuesByAttributes($ids);
        }

        return $ids;
    }

    private function getVendor(?string $vendorId): ?Vendor
    {
        return $this->entityManager->getRepository(Vendor::class)->findOneBy(['id' => $vendorId]);
    }

    private function fillImages(SaveProductRequestDTO $persistable, Product $product): void
    {
        if (empty($persistable->images)) {
            return;
        }

        $existingImages = $product->getImages();
        $existingImageIds = $existingImages->map(fn (ProductImage $productImage) => $productImage->getFile()->getId());
        $unique = array_filter($persistable->images, function ($image) use ($existingImageIds) {
            $id = $image['id'] ?? null;

            return empty($id) || !$existingImageIds->contains($id);
        });

        foreach ($unique as $image) {
            /** @var FileRequestDTO $fileRequest */
            $fileRequest = $this->createFileRequestDTO($image);
            $image = $this->fileService->processFileRequestDTO($fileRequest, null);

            $productImage = new ProductImage();
            $productImage->setFile($image);
            $productImage->setProduct($product);

            $product->addImage($productImage);
        }
    }
}
