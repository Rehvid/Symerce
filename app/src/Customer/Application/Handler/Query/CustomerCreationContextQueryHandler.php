<?php

declare(strict_types=1);

namespace App\Customer\Application\Handler\Query;

use App\Customer\Application\Assembler\CustomerAssembler;
use App\Customer\Application\Query\GetCustomerCreationContextQuery;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class CustomerCreationContextQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CustomerAssembler $assembler
    ) {}

    public function __invoke(GetCustomerCreationContextQuery $query): array
    {
        return $this->assembler->toFormContextResponse();
    }
}
