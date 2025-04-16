<?php

declare(strict_types=1);

namespace App\DTO\Request\Vendor;

use App\Interfaces\PersistableInterface;

use App\Traits\FileTransformerTrait;
use Symfony\Component\Validator\Constraints as Assert;

class VendorSaveRequestDTO implements PersistableInterface
{
    use FileTransformerTrait;

    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public readonly string $name,
        public readonly bool $isActive,
        public array $image = [],
    ) {
        $this->image = $this->transformToFileRequestDTO($image);
    }
}
