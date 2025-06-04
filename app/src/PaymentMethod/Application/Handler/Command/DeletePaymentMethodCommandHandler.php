<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\PaymentMethod\Application\Command\DeletePaymentMethodCommand;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;

final readonly class DeletePaymentMethodCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private  PaymentMethodRepositoryInterface $repository,
    ) {}

    public function __invoke(DeletePaymentMethodCommand $command): void
    {
        $this->repository->remove(
            $this->repository->findById($command->paymentMethodId)
        );
    }
}
