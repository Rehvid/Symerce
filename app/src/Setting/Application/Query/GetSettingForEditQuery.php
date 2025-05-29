<?php

declare(strict_types=1);

namespace App\Setting\Application\Query;

use App\Admin\Domain\Entity\Setting;
use App\Shared\Application\Query\QueryInterface;

final readonly class GetSettingForEditQuery implements QueryInterface
{
    public function __construct(public Setting $setting) {}
}
