<?php

declare(strict_types=1);

namespace App\Carrier\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;

final readonly class GetCarrierForEditQuery implements QueryInterface
{
    public function __construct(
        public int $carrierId,
    ) {}
}
