<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\PaymentMethod\PaymentMethodFormResponse;
use App\Admin\Application\DTO\Response\PaymentMethod\PaymentMethodListResponse;
use App\Entity\PaymentMethod;
use App\Factory\MoneyFactory;

final readonly class PaymentMethodAssembler
{
    public function __construct(
        private MoneyFactory $moneyFactory,
        private ResponseHelperAssembler $responseHelperAssembler,
    ) {
    }

    /**
     * @param array<int, mixed> $paginatedData
     * @return array<string, mixed>
     */
    public function toListResponse(array $paginatedData): array
    {
        $paymentMethodListCollection = array_map(
            fn (PaymentMethod $paymentMethod) => $this->createPaymentMethodListResponse($paymentMethod),
            $paginatedData
        );

        return $this->responseHelperAssembler->wrapListWithAdditionalData($paymentMethodListCollection);
    }

    /**
     * @return array<string, mixed>
     */
    public function toFormDataResponse(PaymentMethod $paymentMethod): array
    {
        $image = $paymentMethod->getImage();
        $name = $paymentMethod->getName();

        $file = null === $image
            ? null
            : $this->responseHelperAssembler->toFileResponse($image->getId(), $name, $image->getPath());

        return $this->responseHelperAssembler->wrapAsFormData(
            new PaymentMethodFormResponse(
                code: $paymentMethod->getCode(),
                name: $name,
                fee: $this->moneyFactory->create($paymentMethod->getFee())->getFormattedAmount(),
                isActive: $paymentMethod->isActive(),
                isRequireWebhook: $paymentMethod->isRequiresWebhook(),
                file: $file
            )
        );
    }

    private function createPaymentMethodListResponse(PaymentMethod $paymentMethod): PaymentMethodListResponse
    {
        return new PaymentMethodListResponse(
            id: $paymentMethod->getId(),
            name: $paymentMethod->getName(),
            code: $paymentMethod->getCode(),
            isActive: $paymentMethod->isActive(),
            fee: $this->moneyFactory->create($paymentMethod->getFee()),
            imagePath: $this->responseHelperAssembler->buildPublicFilePath($paymentMethod->getImage()?->getPath()),
        );
    }
}
