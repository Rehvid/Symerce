<?php

declare(strict_types=1);

namespace App\Category\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;

final readonly class GetCategoryForEditQuery implements QueryInterface
{
    public function __construct(public int $categoryId)
    {
    }
}
