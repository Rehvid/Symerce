<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Domain\Entity\PaymentMethod;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\PaymentMethod\Application\Command\DeletePaymentMethodCommand;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;

final readonly class DeletePaymentMethodCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private  PaymentMethodRepositoryInterface $repository,
    ) {}

    public function __invoke(DeletePaymentMethodCommand $command): void
    {
        /** @var ?PaymentMethod $paymentMethod */
        $paymentMethod = $this->repository->findById($command->paymentMethodId);
        if (null === $paymentMethod) {
            throw EntityNotFoundException::for(PaymentMethod::class, $command->paymentMethodId);
        }

        $this->repository->remove($paymentMethod);
    }
}
