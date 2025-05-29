<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Handler\Command;

use App\PaymentMethod\Application\Command\DeletePaymentMethodCommand;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final readonly class DeletePaymentMethodHandler implements CommandHandlerInterface
{
    public function __construct(
        private  PaymentMethodRepositoryInterface $repository,
    ) {}

    public function __invoke(DeletePaymentMethodCommand $command): void
    {
        $this->repository->remove($command->paymentMethod);
    }
}
