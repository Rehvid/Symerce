<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;
use App\Common\Application\Search\Dto\SearchData;

final readonly class GetPaymentMethodListQuery implements QueryInterface
{
    public function __construct(public SearchData $searchData)
    {
    }
}
