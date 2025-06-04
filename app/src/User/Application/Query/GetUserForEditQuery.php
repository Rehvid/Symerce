<?php

declare(strict_types=1);

namespace App\User\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;

final readonly class GetUserForEditQuery implements QueryInterface
{
    public function __construct(
        public int $userId,
    ) {
    }
}
