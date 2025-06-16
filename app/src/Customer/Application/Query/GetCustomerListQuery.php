<?php

declare(strict_types=1);

namespace App\Customer\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;
use App\Common\Application\Search\Dto\SearchData;

final readonly class GetCustomerListQuery implements QueryInterface
{
    public function __construct(public SearchData $searchData)
    {
    }
}
