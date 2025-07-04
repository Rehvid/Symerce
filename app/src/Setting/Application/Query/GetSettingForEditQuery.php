<?php

declare(strict_types=1);

namespace App\Setting\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;

final readonly class GetSettingForEditQuery implements QueryInterface
{
    public function __construct(public int $settingId)
    {
    }
}
