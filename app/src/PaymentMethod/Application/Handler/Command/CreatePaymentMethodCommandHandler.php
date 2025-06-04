<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\PaymentMethod\Application\Command\CreatePaymentMethodCommand;
use App\PaymentMethod\Application\Hydrator\PaymentMethodHydrator;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;

final readonly class CreatePaymentMethodCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private PaymentMethodRepositoryInterface $repository,
        private PaymentMethodHydrator $hydrator,
    ) {}

    public function __invoke(CreatePaymentMethodCommand $command): IdResponse
    {
        $paymentMethod = $this->hydrator->hydrate($command->data);
        $paymentMethod->setPosition($this->repository->getMaxPosition() + 1);

        $this->repository->save($paymentMethod);

        return new IdResponse($paymentMethod->getId());
    }
}
