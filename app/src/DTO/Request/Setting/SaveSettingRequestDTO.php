<?php

declare(strict_types=1);

namespace App\DTO\Request\Setting;

use App\Interfaces\PersistableInterface;
use Symfony\Component\Validator\Constraints as Assert;

class SaveSettingRequestDTO implements PersistableInterface
{
    public function __construct(
        public ?int $id,
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public string $name,
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public string $value,
        #[Assert\NotBlank] public string $type,
        public bool $isProtected = false,
    ){}
}
