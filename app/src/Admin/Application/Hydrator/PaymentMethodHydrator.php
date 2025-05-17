<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Application\DTO\Request\PaymentMethod\SavePaymentMethodRequest;
use App\Entity\PaymentMethod;
use App\Service\FileService;
use App\Traits\FileRequestMapperTrait;

final readonly class PaymentMethodHydrator
{
    public function __construct(private FileService $fileService){}

    use FileRequestMapperTrait;

    public function hydrate(SavePaymentMethodRequest $request, PaymentMethod $paymentMethod): PaymentMethod
    {
        $paymentMethod->setActive($request->isActive);
        $paymentMethod->setName($request->name);
        $paymentMethod->setCode($request->code);
        $paymentMethod->setFee($request->fee);

        $this->setThumbnail($request, $paymentMethod);

        return $paymentMethod;
    }

    private function setThumbnail(SavePaymentMethodRequest $request, PaymentMethod $paymentMethod)
    {
        if (empty($request->thumbnail)) {
            return;
        }

        $thumbnailProcess = $this->createFileRequestDTOs($request->thumbnail);

        foreach ($thumbnailProcess as $image) {
            $paymentMethod->setImage(
                $this->fileService->processFileRequestDTO($image, $paymentMethod->getImage())
            );
        }
    }
}
