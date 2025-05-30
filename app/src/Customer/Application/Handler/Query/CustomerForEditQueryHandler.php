<?php

declare(strict_types=1);

namespace App\Customer\Application\Handler\Query;

use App\Customer\Application\Assembler\CustomerAssembler;
use App\Customer\Application\Query\GetCustomerForEditQuery;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class CustomerForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CustomerAssembler $assembler
    ) {

    }

    public function __invoke(GetCustomerForEditQuery $query): array
    {
        return $this->assembler->toFormResponse($query->customer);
    }
}
