<?php

declare(strict_types=1);

namespace App\DTO\Admin\Request\Category;

use App\DTO\Admin\Request\PersistableInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Traits\FileRequestMapperTrait;
use Symfony\Component\Validator\Constraints as Assert;

final class SaveCategoryRequestDTO implements PersistableInterface, RequestDtoInterface
{
    use FileRequestMapperTrait;

    /**
     * @param array<string, mixed> $image
     *
     * @throws \ReflectionException
     */
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public readonly string $name,
        public readonly bool $isActive,
        public readonly ?string $slug = null,
        public readonly int|string|null $parentCategoryId = null,
        public readonly ?string $description = null,
        public array $image = [],
    ) {
        $this->image = $this->createFileRequestDTOs($image);
    }
}
