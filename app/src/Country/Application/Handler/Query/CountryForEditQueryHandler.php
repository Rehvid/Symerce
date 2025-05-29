<?php

declare(strict_types=1);

namespace App\Country\Application\Handler\Query;

use App\Country\Application\Assembler\CountryAssembler;
use App\Country\Application\Query\GetCountryForEditQuery;
use App\Shared\Application\Query\QueryHandlerInterface;


final readonly class CountryForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CountryAssembler $assembler
    ) {}

    public function __invoke(GetCountryForEditQuery $query): array
    {
        return $this->assembler->toFormResponse($query->country);
    }
}
