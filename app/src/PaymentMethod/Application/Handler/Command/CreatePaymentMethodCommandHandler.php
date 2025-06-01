<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Handler\Command;

use App\Admin\Domain\Entity\PaymentMethod;
use App\PaymentMethod\Application\Command\CreatePaymentMethodCommand;
use App\PaymentMethod\Application\Hydrator\PaymentMethodHydrator;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;

final readonly class CreatePaymentMethodCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private PaymentMethodRepositoryInterface $repository,
        private PaymentMethodHydrator $hydrator,
    ) {}

    public function __invoke(CreatePaymentMethodCommand $command): IdResponse
    {
        $paymentMethod = $this->hydrator->hydrate($command->data);
        $paymentMethod->setOrder($this->repository->getMaxOrder() + 1);

        $this->repository->save($paymentMethod);

        return new IdResponse($paymentMethod->getId());
    }
}
