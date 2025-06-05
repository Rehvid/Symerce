<?php

declare(strict_types=1);

namespace App\Category\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\FileData;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCategoryRequest implements ArrayHydratableInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public string $name,
        public bool $isActive,
        public ?string $metaTitle = null,
        public ?string $metaDescription = null,
        public ?string $slug = null,
        public int|string|null $parentCategoryId = null,
        public ?string $description = null,
        public ?FileData $fileData = null,
    ) {

    }

    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $image = $data['thumbnail'] ?? null;
        $fileData = null;
        if (!empty($image)) {
            $fileData = FileData::fromArray($image[0]);
        }

        return new self(
            name: $data['name'],
            isActive: $data['isActive'],
            metaTitle: $data['metaTitle'] ?? null,
            metaDescription: $data['metaDescription'] ?? null,
            slug: $data['slug'],
            parentCategoryId: $data['parentCategoryId'],
            description: $data['description'],
            fileData: $fileData,
        );
    }
}
