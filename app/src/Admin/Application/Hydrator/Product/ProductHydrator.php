<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator\Product;

use App\Admin\Application\DTO\Request\Product\SaveProductPromotionRequest;
use App\Admin\Application\DTO\Request\Product\SaveProductRequest;
use App\Admin\Application\DTO\Request\Product\SaveProductStockRequest;
use App\Admin\Application\Hydrator\PromotionHydrator;
use App\Admin\Domain\Entity\DeliveryTime;
use App\Admin\Domain\Entity\Product;
use App\Admin\Domain\Repository\DeliveryTimeRepositoryInterface;
use App\Admin\Domain\Repository\VendorRepositoryInterface;
use App\Admin\Infrastructure\Slug\SluggerService;
use App\Shared\Application\Factory\ValidationExceptionFactory;



final readonly class ProductHydrator
{
    public function __construct(
        private VendorRepositoryInterface       $vendorRepository,
        private DeliveryTimeRepositoryInterface $deliveryTimeRepository,
        private SluggerService                 $sluggerService,
        private PromotionHydrator               $promotionHydrator,
        private ProductStockHydrator            $productStockHydrator,
        private ProductCategoryHydrator         $productCategoryHydrator,
        private ProductTagHydrator              $productTagHydrator,
        private ProductAttributeValueHydrator   $productAttributeValueHydrator,
        private ProductImageHydrator            $productImageHydrator,
        private ValidationExceptionFactory $validationExceptionFactory
    ) {

    }

    public function hydrate(SaveProductRequest $request, Product $product): Product
    {
        /** @var DeliveryTime|null $deliveryTime */
        $deliveryTime = $this->deliveryTimeRepository->findById($request->deliveryTime);
        if (null === $deliveryTime) {
            $this->validationExceptionFactory->createNotFound('deliveryTime');
        }

        $product->setVendor($this->vendorRepository->findById($request->vendor));
        $product->setDeliveryTime($deliveryTime);
        $product->setName($request->name);
        $product->setActive($request->isActive);
        $product->setDescription($request->description);
        $product->setRegularPrice($request->regularPrice);

        $this->productCategoryHydrator->hydrate($request->categories, $request->mainCategory, $product);
        $this->productTagHydrator->hydrate($request->tags, $product);
        $this->productAttributeValueHydrator->hydrate($request->attributes, $product);
        $this->productImageHydrator->hydrate($request->images, $product);

        $this->handlePromotion($request->productPromotionRequest, $product);
        $this->saveProductStock($request->productStockRequest, $product);

        return $product;
    }


    //TODO: Service/Usecase maybe
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
    //TODO: end

    private function handlePromotion(?SaveProductPromotionRequest $request, Product $product): void
    {
        $promotion = $product->getPromotionForProductTab();
        if (null === $request) {
            if (null !== $promotion) {
                $product->removePromotion($promotion);
            }
            return;
        }

        $this->savePromotion($request, $product);
    }

    private function savePromotion(SaveProductPromotionRequest $request, Product $product): void
    {
        $promotion = $this->promotionHydrator->hydrate($request, $product->getPromotionForProductTab());
        $promotion->setProduct($product);

        $product->addPromotion($promotion);
    }

    private function saveProductStock(SaveProductStockRequest $request, Product $product): void
    {
        $product->setStock(
            $this->productStockHydrator->hydrate(
                $request,
                $product,
                $product->hasStock() ? $product->getStock() : null
            )
        );
    }
}
