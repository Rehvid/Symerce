<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\Setting;

use App\Enums\SettingType;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class SaveSettingRequest implements RequestDtoInterface
{
    public function __construct(
        public ?int $id,
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public string $name,
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public string $value,
        #[Assert\NotBlank] #[Assert\Choice(callback: [SettingType::class, 'values'])] public string $type,
        public ?bool $isProtected,
        public ?bool $isJson
    ) {
    }
}
