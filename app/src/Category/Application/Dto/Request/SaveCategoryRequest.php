<?php

declare(strict_types=1);

namespace App\Category\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\FileData;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCategoryRequest implements ArrayHydratableInterface
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;

    #[Assert\NotBlank]
    public bool $isActive;

    public ?string $metaTitle;

    public ?string $metaDescription;

    public ?string $slug; //TODO: Check it if is not null

    public int|string|null $parentCategoryId;

    public ?string $description;

    public ?FileData $fileData;

    public function __construct(
        string $name,
        bool $isActive,
        ?string $metaTitle = null,
        ?string $metaDescription = null,
        ?string $slug = null,
        int|string|null $parentCategoryId = null,
        ?string $description = null,
        ?FileData $fileData = null,
    ) {
        $this->name = $name;
        $this->isActive = $isActive;
        $this->metaTitle = $metaTitle;
        $this->metaDescription = $metaDescription;
        $this->slug = $slug;
        $this->parentCategoryId = $parentCategoryId;
        $this->description = $description;
        $this->fileData = $fileData;
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
