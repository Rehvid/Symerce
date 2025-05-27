<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Customer;

use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use App\Shared\Domain\Repository\CustomerRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DeleteCustomerUseCase implements DeleteUseCaseInterface
{

    public function __construct(
        private CustomerRepositoryInterface $repository,
    ) {}

    public function execute(int|string $entityId): void
    {
        $customer = $this->repository->findById($entityId);
        if (null === $customer) {
            throw new EntityNotFoundException();
        }

        $this->repository->remove($customer);
    }
}
