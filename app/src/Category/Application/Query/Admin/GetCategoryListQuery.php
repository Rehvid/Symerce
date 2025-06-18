<?php

declare(strict_types=1);

namespace App\Category\Application\Query\Admin;

use App\Common\Application\Query\Interfaces\QueryInterface;
use App\Common\Application\Search\Dto\SearchData;

final readonly class GetCategoryListQuery implements QueryInterface
{
    public function __construct(public SearchData $searchData)
    {
    }
}
