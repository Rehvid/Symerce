<?php

declare(strict_types=1);

namespace App\Order\Application\Factory;

use App\Admin\Domain\Repository\CarrierRepositoryInterface;
use App\Admin\Domain\Repository\ProductRepositoryInterface;
use App\Admin\Infrastructure\Utils\ArrayUtils;
use App\Common\Domain\Entity\Carrier;
use App\Common\Domain\Entity\Country;
use App\Common\Domain\Entity\PaymentMethod;
use App\Common\Domain\Entity\Product;
use App\Country\Domain\Repository\CountryRepositoryInterface;
use App\Order\Application\Dto\Response\OrderFormContext;
use App\Order\Domain\Enums\CheckoutStep;
use App\Order\Domain\Enums\OrderStatus;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class OrderFormContextResponseFactory
{
    public function __construct(
        private TranslatorInterface $translator,
        private ProductRepositoryInterface $productRepository,
        private PaymentMethodRepositoryInterface $paymentMethodRepository,
        private CarrierRepositoryInterface $carrierRepository,
        private CountryRepositoryInterface $countryRepository,
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
            availableCountries: $this->getAvailableCountries(),
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

    private function getAvailableCountries(): array
    {
        $items = $this->countryRepository->findBy(['isActive' => true]);

        return ArrayUtils::buildSelectedOptions(
            items: $items,
            labelCallback: fn (Country $country) => $country->getName(),
            valueCallback: fn (Country $country) => $country->getId(),
        );
    }
}
