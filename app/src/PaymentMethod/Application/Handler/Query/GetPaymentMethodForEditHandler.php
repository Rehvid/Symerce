<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Handler\Query;

use App\PaymentMethod\Application\Assembler\PaymentMethodAssembler;
use App\PaymentMethod\Application\Query\GetPaymentMethodForEditQuery;
use App\Shared\Application\Query\QueryHandlerInterface;


final readonly class GetPaymentMethodForEditHandler implements QueryHandlerInterface
{
    public function __construct(
        private PaymentMethodAssembler $paymentMethodAssembler,
    ) {
    }

    public function __invoke(GetPaymentMethodForEditQuery $query): array
    {
        return $this->paymentMethodAssembler->toFormDataResponse($query->paymentMethod);
    }
}
