<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Application\DTO\Request\Product\SaveProductPromotionRequest;
use App\Admin\Application\DTO\Request\Product\SaveProductRequest;
use App\Admin\Domain\Entity\Attribute;
use App\Admin\Domain\Entity\AttributeValue;
use App\Admin\Domain\Entity\Category;
use App\Admin\Domain\Entity\DeliveryTime;
use App\Admin\Domain\Entity\Product;
use App\Admin\Domain\Entity\Promotion;
use App\Admin\Domain\Entity\Tag;
use App\Admin\Domain\Entity\Vendor;
use App\Admin\Domain\Enums\ReductionType;
use App\Admin\Infrastructure\Repository\AttributeDoctrineRepository;
use App\Admin\Infrastructure\Slug\SluggerService;
use App\DTO\Admin\Request\FileRequestDTO;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;


//TODO: Refactor
final readonly class ProductHydrator
{
    public function __construct(
        private SluggerService $sluggerService,
        private readonly EntityManagerInterface $entityManager,
    ) {

    }

    public function hydrate(SaveProductRequest $request, Product $product): mixed
    {
        $product->setVendor($this->getVendor($request->vendor));
        $product->setName($request->name);
        $product->setActive($request->isActive);
        $product->setDescription($request->description);
        $product->setRegularPrice($request->regularPrice);
        $product->setQuantity((int) $request->quantity);


        $this->fillCategories($request, $product);
        $this->fillAttributeValues($request, $product);
        $this->fillTags($request, $product);
        $this->fillDeliveryTime($request, $product);
        $this->fillImages($request, $product);
        if ($request->productPromotionRequest) {
            $this->addPromotion($request->productPromotionRequest, $product);
        }


        return $product;
    }

    public function saveSlug(string $name, ?string $slug): string
    {
        if (null === $slug || empty(trim($slug))) {
            return $this->generateSlug($name);
        }

        return $this->generateSlug($slug);
    }

    public function generateSlug(string $name): string
    {
        return $this->sluggerService->slugifyUnique($name, Product::class, 'slug');
    }

    private function fillCategories(SaveProductRequest $request, Product $product): void
    {
        $categories = $this->getCategories($request->categories);
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

    private function fillDeliveryTime(SaveProductRequest $request, Product $product): void
    {
        $deliveryTime = $this->entityManager->getRepository(DeliveryTime::class)->find($request->deliveryTime);
        if (null === $deliveryTime) {
            return;
        }
        $product->setDeliveryTime($deliveryTime);
    }

    private function fillTags(SaveProductRequest $request, Product $product): void
    {
        $tags = $this->getTags($request->tags);
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

    private function fillAttributeValues(SaveProductRequest $request, Product $product): void
    {
        $attributes = $this->getAttributes($request->attributes);

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
            /** @var AttributeDoctrineRepository $attributeRepository */
            $attributeRepository = $this->entityManager->getRepository(Attribute::class);

            return $attributeRepository->getAttributeValuesByAttributes($ids);
        }

        return $ids;
    }

    private function getVendor(?string $vendorId): ?Vendor
    {
        return $this->entityManager->getRepository(Vendor::class)->findOneBy(['id' => $vendorId]);
    }

    private function fillImages(SaveProductRequest $request, Product $product): void
    {
//        if (empty($request->images)) {
//            return;
//        }
//
//        $existingImages = $product->getImages();
//        $existingImageIds = $existingImages->map(fn (ProductImage $productImage) => $productImage->getFile()->getId());
//        $unique = array_filter($request->images, function ($image) use ($existingImageIds) {
//            $id = $image['id'] ?? null;
//
//            return empty($id) || !$existingImageIds->contains($id);
//        });
//
//        foreach ($unique as $image) {
//            /** @var FileRequestDTO $fileRequest */
//            $fileRequest = $this->createFileRequestDTO($image);
//            $image = $this->fileService->processFileRequestDTO($fileRequest, null);
//
//            $productImage = new ProductImage();
//            $productImage->setFile($image);
//            $productImage->setProduct($product);
//
//            $product->addImage($productImage);
//        }
    }

    private function addPromotion(SaveProductPromotionRequest $request, Product $product): void
    {
        $promotion = new Promotion();
        $promotion->setProduct($product);
        $promotion->setType(ReductionType::tryFrom($request->reductionType));
        $promotion->setReduction($request->reduction);
        $promotion->setActive($request->isActive);
        $promotion->setStartsAt($request->startDate->get());
        $promotion->setEndsAt($request->endDate->get());

        $product->addPromotion($promotion);
    }
}
