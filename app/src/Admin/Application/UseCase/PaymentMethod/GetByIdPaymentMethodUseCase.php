<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\PaymentMethod;

use App\Admin\Application\Assembler\PaymentMethodAssembler;
use App\Admin\Domain\Entity\PaymentMethod;
use App\Admin\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetByIdPaymentMethodUseCase implements GetByIdUseCaseInterface
{
    public function __construct(
        private PaymentMethodRepositoryInterface $paymentMethodRepository,
        private PaymentMethodAssembler $paymentMethodAssembler,
    ) {
    }


    public function execute(string|int $entityId): array
    {
        /** @var ?PaymentMethod $paymentMethod */
        $paymentMethod = $this->paymentMethodRepository->find($entityId);
        if (!$paymentMethod) {
            throw new EntityNotFoundException();
        }

        return $this->paymentMethodAssembler->toFormDataResponse($paymentMethod);
    }
}
