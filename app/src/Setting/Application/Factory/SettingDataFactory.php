<?php

declare(strict_types=1);

namespace App\Setting\Application\Factory;

use App\Setting\Application\Dto\Request\UpdateSettingRequest;
use App\Setting\Application\Dto\SettingData;
use App\Setting\Domain\Enums\SettingValueType;
use App\Setting\Domain\ValueObject\SettingValueVO;

final readonly class SettingDataFactory
{
    public function fromRequest(UpdateSettingRequest $updateRequest): SettingData
    {
        return new SettingData(
            name: $updateRequest->name,
            settingValueVO: new SettingValueVO(
                SettingValueType::from($updateRequest->settingValueType),
                $updateRequest->value
            ),
            isActive: $updateRequest->isActive,
        );
    }
}
