<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\PaymentMethod;

use App\Admin\Application\DTO\Request\PaymentMethod\SavePaymentMethodRequest;
use App\Admin\Application\Hydrator\PaymentMethodHydrator;
use App\Admin\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Entity\PaymentMethod;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;

/**
 * @implements CreateUseCaseInterface<SavePaymentMethodRequest>
 */
final readonly class CreatePaymentMethodUseCase implements CreateUseCaseInterface
{
    public function __construct(
        private PaymentMethodHydrator $hydrator,
        private PaymentMethodRepositoryInterface $repository
    ) {

    }

    /** @return array<string, int> */
    public function execute(RequestDtoInterface $requestDto): array
    {
        $paymentMethod = new PaymentMethod();
        $paymentMethod->setOrder($this->repository->getMaxOrder() + 1);

        $this->hydrator->hydrate($requestDto, $paymentMethod);

        $this->repository->save($paymentMethod);

        return (new IdResponse($paymentMethod->getId()))->toArray();
    }
}
