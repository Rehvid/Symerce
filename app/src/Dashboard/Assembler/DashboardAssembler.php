<?php

declare(strict_types=1);

namespace App\Dashboard\Assembler;

use App\Cart\Domain\Repository\CartRepositoryInterface;
use App\Common\Application\Factory\MoneyFactory;
use App\Common\Application\Service\FileService;
use App\Common\Domain\Entity\Order;
use App\Common\Domain\Entity\OrderItem;
use App\Common\Domain\Entity\Product;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Dashboard\Dto\Response\DashboardBestseller;
use App\Dashboard\Dto\Response\DashboardList;
use App\Dashboard\Dto\Response\DashboardOrderItem;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class DashboardAssembler
{
    public function __construct(
      private CustomerRepositoryInterface $customerRepository,
      private OrderRepositoryInterface $orderRepository,
      private ProductRepositoryInterface $productRepository,
      private CartRepositoryInterface $cartRepository,
      private MoneyFactory $factory,
      private UrlGeneratorInterface $urlGenerator,
      private FileService $fileService,
    ) {
    }

    public function toListResponse(): DashboardList
    {
        return new DashboardList(
            customersCount: $this->customerRepository->getCount(),
            ordersCount: $this->orderRepository->getCount(),
            productsCount: $this->productRepository->getCount(),
            activeCartsCount: $this->cartRepository->getCount(),
            orders: array_map(
                fn (Order $order) => $this->createOrderItem($order),
                $this->orderRepository->findLatestOrders(10)
            ),
            bestSellers: array_map(
                fn (array $item) => $this->createBestseller($item),
                $this->productRepository->findBestSellingProducts(10)
            )
        );
    }

    private function createOrderItem(Order $order): DashboardOrderItem
    {
        $total = $order->getTotalPrice() ?? '-';
        if ($total) {
            $total = ($this->factory->create($total))->getFormattedAmountWithSymbol();
        }

        $products = array_map(
            function (OrderItem $item) {
                $product = $item->getProduct();
                return [
                    'name' => $product?->getName(),
                    'count' => $item->getQuantity(),
                    'showUrl' => $this->urlGenerator->generate('shop.product_show', [
                        'slug' => $product?->getSlug(),
                        'slugCategory' => $product?->getMainCategory()?->getSlug(),
                    ]),
                ];
            },
            $order->getOrderItems()->toArray()
        );


        return new DashboardOrderItem(
            customer: $order->getFullNameCustomer(),
            products: $products,
            total: $total,
            status: $order->getStatus()->value
        );
    }

    /** @param array<int|string, mixed> $item */
    private function createBestseller(array $item): DashboardBestseller
    {
        $product = $item[0];
        $quantity = $item['quantity'] ?? 0;

        if (!$product instanceof Product) {
            throw new \RuntimeException('Product not found');
        }

        return new DashboardBestseller(
            productImage: $this->fileService->preparePublicPathToFile($product->getThumbnailImage()?->getFile()?->getPath()),
            productName: $product->getName(),
            mainCategory: $product->getMainCategory()?->getName(),
            isInStock: $product->isInStock(),
            totalSold: (int) $quantity,
        );
    }
}
