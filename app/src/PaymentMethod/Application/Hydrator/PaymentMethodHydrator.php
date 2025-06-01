<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Hydrator;

use App\Admin\Application\Service\FileService;
use App\Admin\Domain\Entity\PaymentMethod;
use App\PaymentMethod\Application\Dto\PaymentMethodData;


final readonly class PaymentMethodHydrator
{
    public function __construct(
        private FileService $fileService
    ) {}


    public function hydrate(PaymentMethodData $data, ?PaymentMethod $paymentMethod = null): PaymentMethod
    {
        $paymentMethod ??= new PaymentMethod();
        $paymentMethod->setActive($data->isActive);
        $paymentMethod->setName($data->name);
        $paymentMethod->setCode($data->code);
        $paymentMethod->setFee($data->fee);
        $paymentMethod->setConfig($data->config);

        if ($data->fileData) {
            $this->fileService->replaceFile($paymentMethod, $data->fileData);
        }

        return $paymentMethod;
    }
}
