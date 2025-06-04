<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): mixed;
}
