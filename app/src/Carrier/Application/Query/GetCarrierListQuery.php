<?php

declare(strict_types=1);

namespace App\Carrier\Application\Query;

use App\Shared\Application\Query\QueryInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class GetCarrierListQuery implements QueryInterface
{
    public function __construct(
        public Request $request
    ) {}
}
