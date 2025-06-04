<?php

declare(strict_types=1);

namespace App\Attribute\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class GetAttributeListQuery implements QueryInterface
{
    public function __construct(
        public Request $request,
    ) {}
}
