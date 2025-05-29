<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Domain\Entity\Setting;
use App\Setting\Application\Dto\Request\UpdateSettingRequest;
use App\Setting\Domain\Enums\SettingType;

final readonly class SettingHydrator
{
    public function hydrate(UpdateSettingRequest $request, Setting $setting): Setting
    {
        $setting->setValue($request->value);
        $setting->setType(SettingType::from($request->type));
        $setting->setName($request->name);
        $setting->setIsJson($request->isJson);

        return $setting;
    }
}
