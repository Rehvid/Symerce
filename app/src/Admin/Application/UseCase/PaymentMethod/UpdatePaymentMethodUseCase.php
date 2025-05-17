<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\PaymentMethod;

use App\Admin\Application\DTO\Request\PaymentMethod\SavePaymentMethodRequest;
use App\Admin\Application\Hydrator\PaymentMethodHydrator;
use App\Admin\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

/**
 * @implements UpdateUseCaseInterface<SavePaymentMethodRequest>
 */
final readonly class UpdatePaymentMethodUseCase implements UpdateUseCaseInterface
{
    public function __construct(
        private PaymentMethodHydrator $hydrator,
        private PaymentMethodRepositoryInterface $repository
    ) {

    }

    /** @return array<string, int> */
    public function execute(RequestDtoInterface $requestDto, string|int $entityId): array
    {
        $paymentMethod = $this->repository->find($entityId);
        if (null === $paymentMethod) {
            throw new EntityNotFoundException();
        }

        $this->hydrator->hydrate($requestDto, $paymentMethod);

        $this->repository->save($paymentMethod);

        return (new IdResponse($paymentMethod->getId()))->toArray();
    }
}
