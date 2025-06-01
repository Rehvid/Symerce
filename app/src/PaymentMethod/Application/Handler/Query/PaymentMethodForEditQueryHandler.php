<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Handler\Query;

use App\Admin\Domain\Entity\PaymentMethod;
use App\PaymentMethod\Application\Assembler\PaymentMethodAssembler;
use App\PaymentMethod\Application\Query\GetPaymentMethodForEditQuery;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;
use App\Shared\Domain\Exception\EntityNotFoundException;


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
