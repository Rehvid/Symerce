<?php

declare (strict_types=1);

namespace App\Service\DataPersister\Filler;

use App\DTO\Request\PersistableInterface;
use App\DTO\Request\Product\SaveProductRequestDTO;
use App\Entity\Attribute;
use App\Entity\Category;
use App\Entity\DeliveryTime;
use App\Entity\Product;
use App\Entity\Tag;
use App\Entity\Vendor;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;
use App\Service\FileService;
use App\Service\SluggerService;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends BaseEntityFiller<SaveProductRequestDTO>
 */
final class ProductEntityFiller extends BaseEntityFiller
{

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

        return $this->fillEntity($persistable, $product);
    }

    /**
     * @param PersistableInterface $persistable
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
    ): Product
    {
        $entity->setVendor($this->getVendor($persistable->vendor));
        $entity->setName($persistable->name);
        $entity->setActive($persistable->isActive);
        $entity->setDescription($persistable->description);
        $entity->setRegularPrice($persistable->regularPrice);
        $entity->setDiscountPrice($persistable->discountPrice);
        $entity->setQuantity((int) $persistable->quantity);

        $this->fillCategories($persistable, $entity);
        $this->fillAttributeValues($persistable, $entity);
        $this->fillTags($persistable, $entity);
        $this->fillDeliveryTimes($persistable, $entity);
        $this->fillImages($persistable, $entity);


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
        foreach ($categories as $category) {
            $product->addCategory($category);
        }
    }

    private function getCategories(array $categoryIds): array
    {
        return $this->entityManager->getRepository(Category::class)->findBy(['id' => $categoryIds]);
    }

    private function fillDeliveryTimes(SaveProductRequestDTO $persistable, Product $product): void
    {
        $deliveryTimes = $this->getDeliveryTimes($persistable->deliveryTimes);
        $product->getDeliveryTimes()->clear();
        foreach ($deliveryTimes  as $deliveryTime) {
            $product->addDeliveryTime($deliveryTime);
        }
    }

    private function getDeliveryTimes(array $deliveryTimeIds): array
    {
        return $this->entityManager->getRepository(DeliveryTime::class)->findBy(['id' => $deliveryTimeIds]);
    }

    private function fillTags(SaveProductRequestDTO $persistable, Product $product): void
    {
        $tags = $this->getTags($persistable->tags);
        $product->getTags()->clear();
        foreach ($tags as $tag) {
            $product->addTag($tag);
        }
    }

    private function getTags(array $tagIds): array
    {
        return $this->entityManager->getRepository(Tag::class)->findBy(['id' => $tagIds]);
    }

    private function fillAttributeValues(SaveProductRequestDTO $persistable, Product $product): void
    {
        $attributes = $this->getAttributes($persistable->attributes);
        $product->getAttributeValues()->clear();
        foreach ($attributes as $attribute) {
            $product->addAttributeValue($attribute);
        }
    }

    private function getAttributes(array $attributeIds): array
    {
        $ids = [];
        foreach ($attributeIds as $key => $value) {
            $attributeId = str_replace('attribute_', '', $key);
            $ids[$attributeId] = $value;
        }

        return $this->entityManager->getRepository(Attribute::class)->getAttributeValuesByAttributes($ids);
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

        foreach ($persistable->images as $image) {
            $product->addImage($this->fileService->processFileRequestDTO($image, null));
        }
    }
}
