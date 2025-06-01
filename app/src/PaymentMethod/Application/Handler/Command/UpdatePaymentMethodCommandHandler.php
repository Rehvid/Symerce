<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Handler\Command;

use App\Admin\Domain\Entity\PaymentMethod;
use App\PaymentMethod\Application\Command\UpdatePaymentMethodCommand;
use App\PaymentMethod\Application\Hydrator\PaymentMethodHydrator;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Domain\Exception\EntityNotFoundException;

final readonly class UpdatePaymentMethodCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private PaymentMethodRepositoryInterface $repository,
        private PaymentMethodHydrator $hydrator,
    ) {}

    public function __invoke(UpdatePaymentMethodCommand $command): IdResponse
    {
        /** @var ?PaymentMethod $paymentMethod */
        $paymentMethod = $this->repository->findById($command->paymentMethodId);
        if (null === $paymentMethod) {
            throw EntityNotFoundException::for(PaymentMethod::class, $command->paymentMethodId);
        }

        $paymentMethod = $this->hydrator->hydrate($command->data, $paymentMethod);

        $this->repository->save($paymentMethod);

        return new IdResponse($paymentMethod->getId());
    }
}
