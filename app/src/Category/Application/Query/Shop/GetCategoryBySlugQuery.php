<?php

namespace App\Category\Application\Query\Shop;

use App\Common\Application\Query\Interfaces\QueryInterface;

final class GetCategoryBySlugQuery implements QueryInterface
{
    public function __construct(public string $slug) {}
}
