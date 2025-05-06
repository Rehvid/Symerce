<?php

declare(strict_types=1);

namespace App\DTO\Admin\Request\Setting;

use App\DTO\Admin\Request\PersistableInterface;
use App\Enums\SettingType;
use Symfony\Component\Validator\Constraints as Assert;

final class SaveSettingRequestDTO implements PersistableInterface
{
    public function __construct(
        public ?int $id,
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public string $name,
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public string $value,
        #[Assert\NotBlank] #[Assert\Choice(callback: [SettingType::class, 'values'])] public string $type,
        public ?bool $isProtected,
    ) {
    }
}
