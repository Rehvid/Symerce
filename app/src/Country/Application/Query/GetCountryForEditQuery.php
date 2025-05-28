<?php

declare(strict_types=1);

namespace App\Country\Application\Query;

use App\Admin\Domain\Entity\Country;
use App\Shared\Application\Query\QueryInterface;

final readonly class GetCountryForEditQuery implements QueryInterface
{
    public function __construct(
        public Country $country
    ) {}
}
