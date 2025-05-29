<?php

declare(strict_types=1);

namespace App\Admin\Application\Factory\Order;

use App\Admin\Application\DTO\Response\Order\OrderFormContext;
use App\Admin\Domain\Entity\Carrier;
use App\Admin\Domain\Entity\PaymentMethod;
use App\Admin\Domain\Entity\Product;
use App\Admin\Domain\Repository\CarrierRepositoryInterface;
use App\Admin\Domain\Repository\ProductRepositoryInterface;
use App\Admin\Infrastructure\Utils\ArrayUtils;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Shared\Domain\Enums\CheckoutStep;
use App\Shared\Domain\Enums\OrderStatus;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class OrderFormContextResponseFactory
{
    public function __construct(
        private TranslatorInterface $translator,
        private ProductRepositoryInterface $productRepository,
        private PaymentMethodRepositoryInterface $paymentMethodRepository,
        private CarrierRepositoryInterface $carrierRepository,
    ){

    }

    public function create(): OrderFormContext
    {
        return new OrderFormContext(
            availableProducts: $this->getAvailableProducts(),
            availableStatuses: $this->getAvailableStatuses(),
            availableCheckoutSteps: $this->getAvailableCheckoutSteps(),
            availablePaymentMethods: $this->getAvailablePaymentMethods(),
            availableCarriers: $this->getAvailableCarriers(),
        );
    }

    private function getAvailableProducts(): array
    {
        $items = $this->productRepository->findBy(['isActive' => true]);

        return ArrayUtils::buildSelectedOptions(
            items: $items,
            labelCallback: fn(Product $product) =>sprintf('Id: %s, Nazwa: %s', $product->getId(), $product->getName()),
            valueCallback: fn (Product $product) => $product->getId(),
        );
    }

    private function getAvailableStatuses(): array
    {
        return ArrayUtils::buildSelectedOptions(
            items: OrderStatus::cases(),
            labelCallback: fn (OrderStatus $status) => $this->translator->trans("base.order_status_type.{$status->value}"),
            valueCallback: fn (OrderStatus $status) => $status->value
        );
    }

    private function getAvailableCheckoutSteps(): array
    {
        return ArrayUtils::buildSelectedOptions(
            items: CheckoutStep::cases(),
            labelCallback: fn (CheckoutStep $step) => $this->translator->trans("base.checkout_type.{$step->value}"),
            valueCallback: fn (CheckoutStep $step) => $step->value
        );
    }

    private function getAvailablePaymentMethods(): array
    {
        $items = $this->paymentMethodRepository->findBy(['isActive' => true]);

        return ArrayUtils::buildSelectedOptions(
            items: $items,
            labelCallback: fn (PaymentMethod $paymentMethod) => $paymentMethod->getName(),
            valueCallback: fn (PaymentMethod $paymentMethod) => $paymentMethod->getId()
        );
    }

    private function getAvailableCarriers(): array
    {
        $items = $this->carrierRepository->findBy(['isActive' => true]);

        return ArrayUtils::buildSelectedOptions(
            items: $items,
            labelCallback: fn (Carrier $carrier) => $carrier->getName(),
            valueCallback: fn (Carrier $carrier) => $carrier->getId(),
        );
    }
}
