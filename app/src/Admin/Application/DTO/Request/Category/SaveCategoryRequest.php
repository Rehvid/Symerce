<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\Category;

use App\Admin\Domain\Model\FileData;
use App\Shared\Application\Contract\ArrayHydratableInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCategoryRequest implements RequestDtoInterface, ArrayHydratableInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public string $name,
        public bool $isActive,
        public ?string $slug = null,
        public int|string|null $parentCategoryId = null,
        public ?string $description = null,
        public ?FileData $fileData = null,
    ) {

    }

    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $image = $data['image'] ?? null;
        $fileData = null;
        if (!empty($image)) {
            $fileData = FileData::fromArray($image[0]);
        }

        return new self(
            name: $data['name'],
            isActive: $data['isActive'],
            slug: $data['slug'],
            parentCategoryId: $data['parentCategoryId'],
            description: $data['description'],
            fileData: $fileData,
        );
    }
}
