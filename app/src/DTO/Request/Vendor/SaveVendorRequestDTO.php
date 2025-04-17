<?php

declare(strict_types=1);

namespace App\DTO\Request\Vendor;

use App\DTO\Request\PersistableInterface;
use App\Traits\FileRequestMapperTrait;
use Symfony\Component\Validator\Constraints as Assert;

final class SaveVendorRequestDTO implements PersistableInterface
{
    use FileRequestMapperTrait;

    /** @param array<string, mixed> $image
     *
     * @throws \ReflectionException
     */
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public readonly string $name,
        public readonly bool $isActive,
        public array $image = [],
    ) {
        $this->image = $this->createFileRequestDTOs($image);
    }
}
