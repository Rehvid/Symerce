<?php

declare(strict_types=1);

namespace App\Customer\Application\Handler\Query;

use App\Customer\Application\Assembler\CustomerAssembler;
use App\Customer\Application\Query\GetCustomerForEditQuery;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;
use App\Shared\Domain\Entity\Customer;
use App\Shared\Domain\Exception\EntityNotFoundException;

final readonly class CustomerForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CustomerAssembler $assembler,
        private CustomerRepositoryInterface $repository
    ) {

    }

    public function __invoke(GetCustomerForEditQuery $query): array
    {
        /** @var ?Customer $customer */
        $customer = $this->repository->findById($query->customerId);
        if (null === $customer) {
            throw EntityNotFoundException::for(Customer::class, $query->customerId);
        }

        return $this->assembler->toFormResponse($customer);
    }
}
