<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Handler\Command;

use App\PaymentMethod\Application\Command\UpdatePaymentMethodCommand;
use App\PaymentMethod\Application\Hydrator\PaymentMethodHydrator;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;

final readonly class UpdatePaymentMethodCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private PaymentMethodRepositoryInterface $repository,
        private PaymentMethodHydrator $hydrator,
    ) {}

    public function __invoke(UpdatePaymentMethodCommand $command): IdResponse
    {
        $paymentMethod = $this->hydrator->hydrate($command->paymentMethodData, $command->paymentMethod);

        $this->repository->save($paymentMethod);

        return new IdResponse($paymentMethod->getId());
    }
}
