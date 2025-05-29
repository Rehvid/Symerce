<?php

declare(strict_types=1);

namespace App\Currency\Application\Handler\Query;

use App\Currency\Application\Assembler\CurrencyAssembler;
use App\Currency\Application\Query\GetCurrencyForEditQuery;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class CurrencyForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CurrencyAssembler $assembler,
    ) {
    }

    public function __invoke(GetCurrencyForEditQuery $query): array
    {
        return $this->assembler->toFormDataResponse($query->currency);
    }
}
