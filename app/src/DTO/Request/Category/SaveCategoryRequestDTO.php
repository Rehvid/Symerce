<?php

declare(strict_types=1);

namespace App\DTO\Request\Category;

use App\DTO\Request\FileRequestDTO;
use App\Enums\FileMimeType;
use App\Factory\PersistableDTOFactory;
use App\Interfaces\PersistableInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class SaveCategoryRequestDTO implements PersistableInterface
{
    /** @param array<int, mixed> $image
     * @param array<int, int> $imageIds
     *
     * @throws \ReflectionException
     */
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public readonly string $name,
        public readonly bool $isActive,
        public readonly int|string|null $parentCategoryId = null,
        public readonly ?string $description = null,
        public array $image = [],
        public array $imageIds = [],
    ) {
        $this->transformToImageRequestDTO($image);
    }

    /**
     * @param array<int, mixed> $image
     *
     * @throws \ReflectionException
     */
    private function transformToImageRequestDTO(array $image): void
    {
        $result = [];
        foreach ($image as $imageFile) {
            $fileRequestDTO = PersistableDTOFactory::create(FileRequestDTO::class, [
                'size' => $imageFile['size'] ?? null,
                'name' => $imageFile['name'] ?? null,
                'type' => FileMimeType::tryFrom($imageFile['type'] ?? null),
                'content' => $imageFile['content'] ?? null,
            ]);
            $result[] = $fileRequestDTO;
        }

        $this->image = $result;
    }
}
