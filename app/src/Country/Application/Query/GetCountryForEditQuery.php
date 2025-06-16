<?php

declare(strict_types=1);

namespace App\Country\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;

final readonly class GetCountryForEditQuery implements QueryInterface
{
    public function __construct(
        public int $countryId,
    ) {
    }
}
