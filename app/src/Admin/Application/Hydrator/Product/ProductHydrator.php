<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator\Product;

use App\Admin\Application\DTO\Request\Product\SaveProductPromotionRequest;
use App\Admin\Application\DTO\Request\Product\SaveProductRequest;
use App\Admin\Application\DTO\Request\Product\SaveProductStockRequest;
use App\Admin\Application\Hydrator\PromotionHydrator;
use App\Admin\Domain\Repository\DeliveryTimeRepositoryInterface;
use App\Admin\Domain\Repository\VendorRepositoryInterface;
use App\Admin\Infrastructure\Slug\SluggerService;
use App\Common\Domain\Entity\DeliveryTime;
use App\Common\Domain\Entity\Product;
use App\Shared\Application\Factory\MoneyFactory;
use App\Shared\Application\Factory\ValidationExceptionFactory;


final readonly class ProductHydrator
{
    public function __construct(
        private VendorRepositoryInterface       $vendorRepository,
        private DeliveryTimeRepositoryInterface $deliveryTimeRepository,
        private SluggerService                 $sluggerService,
        private MoneyFactory $moneyFactory,
        private ValidationExceptionFactory $validationExceptionFactory,
        private PromotionHydrator               $promotionHydrator,
        private ProductStockHydrator            $productStockHydrator,
        private ProductCategoryHydrator         $productCategoryHydrator,
        private ProductTagHydrator              $productTagHydrator,
        private ProductAttributeValueHydrator   $productAttributeValueHydrator,
        private ProductImageHydrator            $productImageHydrator,
        private ProductPriceHydrator            $productPriceHydrator,
    ) {

    }

    public function hydrate(SaveProductRequest $request, Product $product): Product
    {
        /** @var DeliveryTime|null $deliveryTime */
        $deliveryTime = $this->deliveryTimeRepository->findById($request->deliveryTime);
        if (null === $deliveryTime) {
            $this->validationExceptionFactory->createNotFound('deliveryTime');
        }

        if ($product->getId() === null) {
            $regularPriceChanged = true;
        } else {
            $currentProductPrice = $this->moneyFactory->create($product->getRegularPrice());
            $requestProductPrice = $this->moneyFactory->create($request->regularPrice);
            $regularPriceChanged = !$currentProductPrice->equal($requestProductPrice);
        }

        $product->setVendor($this->vendorRepository->findById($request->vendor));
        $product->setDeliveryTime($deliveryTime);
        $product->setName($request->name);
        $product->setActive($request->isActive);
        $product->setDescription($request->description);
        $product->setRegularPrice($request->regularPrice);

        if ($request->productPromotionRequest === null && $regularPriceChanged) {
            $this->productPriceHydrator->hydrate($product);
        }

        $this->productCategoryHydrator->hydrate($request->categories, $request->mainCategory, $product);
        $this->productTagHydrator->hydrate($request->tags, $product);
        $this->productAttributeValueHydrator->hydrate($request->attributes, $product);
        $this->productImageHydrator->hydrate($request->images, $product);

        $this->handlePromotion($request->productPromotionRequest, $product, $regularPriceChanged);
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

    private function handlePromotion(?SaveProductPromotionRequest $request, Product $product, bool $regularPriceChanged): void
    {
        $existingPromotion = $product->getPromotionForProductTab();

        $hasPromotion = $existingPromotion !== null;
        $shouldRemove = $request === null && $hasPromotion;

        if ($shouldRemove) {
            $product->removePromotion($existingPromotion);
            return;
        }

        if ($request !== null) {
            $this->savePromotion($request, $product, $regularPriceChanged);
            return;
        }


        if ($regularPriceChanged && $hasPromotion) {
            $this->productPriceHydrator->hydrate($product, $existingPromotion);
        }
    }

    private function savePromotion(SaveProductPromotionRequest $request, Product $product, bool $regularPriceChanged): void
    {
        $promotionProduct = $product->getPromotionForProductTab();
        if (null === $promotionProduct) {
            $promotion = $this->promotionHydrator->hydrate($request, $promotionProduct);
            $promotion->setProduct($product);

            $product->addPromotion($promotion);
            $this->productPriceHydrator->hydrate($product, $promotion);
            return;
        }

        $currentReduction = $this->moneyFactory->create($promotionProduct->getReduction());
        $incomingReduction = $this->moneyFactory->create($request->reduction);

        $typeChanged = $promotionProduct->getType()->value !== $request->reductionType;
        $valueChanged = !$currentReduction->equal($incomingReduction);

        $this->promotionHydrator->hydrate($request, $promotionProduct);

        if ($typeChanged || $valueChanged || $regularPriceChanged) {
            $this->productPriceHydrator->hydrate($product, $promotionProduct);
        }
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
