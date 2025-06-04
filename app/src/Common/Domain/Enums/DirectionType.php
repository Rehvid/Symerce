<?php

declare(strict_types=1);

namespace App\Common\Domain\Enums;

enum DirectionType: string
{
    case ASC = 'asc';
    case DESC = 'desc';
}
