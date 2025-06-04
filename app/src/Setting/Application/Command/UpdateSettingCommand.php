<?php

declare(strict_types=1);

namespace App\Setting\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;
use App\Setting\Application\Dto\SettingData;

final readonly class UpdateSettingCommand implements CommandInterface
{
    public function __construct(
        public SettingData $data,
        public int $settingId,
    ) {}
}
