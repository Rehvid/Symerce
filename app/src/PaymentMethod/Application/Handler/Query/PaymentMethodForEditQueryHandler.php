<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Handler\Query;

use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Common\Domain\Entity\PaymentMethod;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\PaymentMethod\Application\Assembler\PaymentMethodAssembler;
use App\PaymentMethod\Application\Query\GetPaymentMethodForEditQuery;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;

final readonly class PaymentMethodForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private PaymentMethodAssembler $paymentMethodAssembler,
        private PaymentMethodRepositoryInterface $repository,
    ) {
    }

    public function __invoke(GetPaymentMethodForEditQuery $query): array
    {
        /** @var ?PaymentMethod $paymentMethod */
        $paymentMethod = $this->repository->findById($query->paymentMethodId);

        if (null === $paymentMethod) {
            throw EntityNotFoundException::for(PaymentMethod::class, $query->paymentMethodId);
        }

        return $this->paymentMethodAssembler->toFormDataResponse($paymentMethod);
    }
}
