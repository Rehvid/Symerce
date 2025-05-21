<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Application\DTO\Request\Setting\SaveSettingRequest;
use App\Admin\Domain\Entity\Setting;
use App\Shared\Domain\Enums\SettingType;

final readonly class SettingHydrator
{
    public function hydrate(SaveSettingRequest $request, Setting $setting): Setting
    {
        $setting->setValue($request->value);
        $setting->setType(SettingType::from($request->type));
        $setting->setName($request->name);
        $setting->setIsJson($request->isJson);

        return $setting;
    }
}
