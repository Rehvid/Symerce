<?php

declare(strict_types=1);

namespace App\Setting\Application\Command;

use App\Setting\Application\Dto\SettingData;
use App\Shared\Application\Command\CommandInterface;

final readonly class UpdateSettingCommand implements CommandInterface
{
    public function __construct(
        public SettingData $settingData,
    ) {}
}
