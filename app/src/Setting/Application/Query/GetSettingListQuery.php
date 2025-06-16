<?php

declare(strict_types=1);

namespace App\Setting\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;
use App\Common\Application\Search\Dto\SearchData;

final readonly class GetSettingListQuery implements QueryInterface
{
    public function __construct(public SearchData $searchData)
    {
    }
}
