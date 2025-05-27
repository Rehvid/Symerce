<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Customer;

use App\Admin\Application\Assembler\CustomerAssembler;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use App\Shared\Domain\Repository\CustomerRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetByIdCustomerUseCase implements GetByIdUseCaseInterface
{

    public function __construct(
        private CustomerRepositoryInterface $repository,
        private CustomerAssembler $assembler,
    ) {}

    public function execute(int|string $entityId): mixed
    {
        $customer = $this->repository->findById($entityId);
        if (null === $customer) {
            throw new EntityNotFoundException();
        }

        return $this->assembler->toFormResponse($customer);
    }
}
