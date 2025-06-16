<?php

declare(strict_types=1);

namespace App\Order\Application\Handler\Query;

use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Order\Application\Assembler\OrderAssembler;
use App\Order\Application\Query\GetOrderCreationContextQuery;

final readonly class OrderCreationContextQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private OrderAssembler $assembler,
    ) {
    }

    public function __invoke(GetOrderCreationContextQuery $query): array
    {
        return $this->assembler->toCreateFormResponse();
    }
}
