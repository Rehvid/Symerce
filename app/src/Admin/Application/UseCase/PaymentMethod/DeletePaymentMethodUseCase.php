<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\PaymentMethod;

use App\Admin\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DeletePaymentMethodUseCase implements DeleteUseCaseInterface
{
    public function __construct(
        private PaymentMethodRepositoryInterface $repository
    ) {}

    public function execute(string|int $entityId): void
    {
        $paymentMethod = $this->repository->find($entityId);
        if (null === $paymentMethod) {
            throw new EntityNotFoundException();
        }

        $this->repository->remove($paymentMethod);
    }
}
