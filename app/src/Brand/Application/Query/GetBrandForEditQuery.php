<?php

declare(strict_types=1);

namespace App\Brand\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;

final readonly class GetBrandForEditQuery implements QueryInterface
{
    public function __construct(public int $brandId)
    {
    }
}
