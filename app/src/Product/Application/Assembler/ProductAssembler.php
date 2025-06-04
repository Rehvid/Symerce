<?php

declare(strict_types=1);

namespace App\Product\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Domain\Enums\ReductionType;
use App\Common\Domain\Entity\Product;
use App\Product\Application\Dto\Response\ProductListResponse;
use App\Product\Application\Factory\ProductFormContextFactory;
use App\Product\Application\Factory\ProductFormResponseFactory;
use App\Shared\Application\Factory\MoneyFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class ProductAssembler
{
    public function __construct(
        private MoneyFactory                    $moneyFactory,
        private UrlGeneratorInterface           $urlGenerator,
        private ResponseHelperAssembler         $responseHelperAssembler,
        private ProductFormResponseFactory      $productFormResponseFactory,
        private ProductFormContextFactory        $productFormContextFactory,
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
        return $this->responseHelperAssembler->wrapFormResponse(
            context: $this->productFormContextFactory->create()
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toFormDataResponse(Product $product): array
    {
         return $this->responseHelperAssembler->wrapFormResponse(
             data: $this->productFormResponseFactory->fromProduct($product),
             context: $this->productFormContextFactory->create()
         );
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
            quantity: 0,
            showUrl: $this->urlGenerator->generate('shop.product_show', [
                'slug' => $product->getSlug(),
                'slugCategory' => $product->getCategories()->first()->getSlug(),
            ]),
        );
    }

}
