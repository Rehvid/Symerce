<?php

declare(strict_types=1);

namespace App\Admin\Country\Application\Handler\Query;

use App\Admin\Country\Application\Assembler\CountryAssembler;
use App\Admin\Country\Application\Query\GetCountryForEditQuery;
use App\Shared\Application\Query\QueryHandlerInterface;


final readonly class GetCountryForEditHandler implements QueryHandlerInterface
{
    public function __construct(
        private CountryAssembler $assembler
    ) {}

    public function __invoke(GetCountryForEditQuery $query): array
    {
        return $this->assembler->toFormResponse($query->country);
    }
}
