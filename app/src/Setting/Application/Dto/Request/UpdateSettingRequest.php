<?php

declare(strict_types=1);

namespace App\Setting\Application\Dto\Request;

use App\Common\Infrastructure\Utils\BoolHelper;
use App\Setting\Domain\Enums\SettingValueType;
use Symfony\Component\Validator\Constraints as Assert;

final class UpdateSettingRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;

    #[Assert\NotBlank]
    public mixed $value;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [SettingValueType::class, 'values'])]
    public string $settingValueType;

    public bool $isActive;

    public function __construct(
        string $name,
        mixed $value,
        string $settingValueType,
        mixed $isActive
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->settingValueType = $settingValueType;
        $this->isActive = BoolHelper::castOrFail($isActive, 'isActive');
    }
}
