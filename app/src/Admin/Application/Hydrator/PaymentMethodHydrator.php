<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Application\DTO\Request\PaymentMethod\SavePaymentMethodRequest;
use App\Admin\Application\Service\FileService;
use App\Admin\Domain\Entity\PaymentMethod;


final readonly class PaymentMethodHydrator
{
    public function __construct(private FileService $fileService){}


    public function hydrate(SavePaymentMethodRequest $request, PaymentMethod $paymentMethod): PaymentMethod
    {
        $paymentMethod->setActive($request->isActive);
        $paymentMethod->setName($request->name);
        $paymentMethod->setCode($request->code);
        $paymentMethod->setFee($request->fee);

        if ($request->fileData) {
            $this->fileService->replaceFile($paymentMethod, $request->fileData);
        }

        return $paymentMethod;
    }
}
