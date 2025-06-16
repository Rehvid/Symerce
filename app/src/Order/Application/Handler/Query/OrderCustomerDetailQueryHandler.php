<?php

declare(strict_types=1);

namespace App\Order\Application\Handler\Query;

use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Common\Domain\Entity\Customer;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Order\Application\Assembler\OrderAssembler;
use App\Order\Application\Query\GetOrderCustomerDetailQuery;

final readonly class OrderCustomerDetailQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        public CustomerRepositoryInterface $customerRepository,
        public OrderAssembler $assembler,
    ) {
    }

    public function __invoke(GetOrderCustomerDetailQuery $query): array
    {
        /** @var ?Customer $customer */
        $customer = $this->customerRepository->findById($query->customerId);
        if (null === $customer) {
            throw EntityNotFoundException::for(Customer::class, $query->customerId);
        }

        return $this->assembler->toCustomerOrderData($customer);
    }
}
