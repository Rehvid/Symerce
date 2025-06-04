<?php

declare(strict_types=1);

namespace App\Setting\Application\Dto\Request;

use App\Common\Application\Dto\Request\RequestDtoInterface;
use App\Setting\Domain\Enums\SettingValueType;
use Symfony\Component\Validator\Constraints as Assert;

final class UpdateSettingRequest implements RequestDtoInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public string $name,
        public mixed $value,
        #[Assert\NotBlank] #[Assert\Choice(callback: [SettingValueType::class, 'values'])] public string $settingValueType,
        public bool $isActive
    ) {
    }
}
