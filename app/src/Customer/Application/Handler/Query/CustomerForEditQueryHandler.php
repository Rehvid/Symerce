<?php

declare(strict_types=1);

namespace App\Customer\Application\Handler\Query;

use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Common\Domain\Entity\Customer;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Customer\Application\Assembler\CustomerAssembler;
use App\Customer\Application\Query\GetCustomerForEditQuery;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;

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
