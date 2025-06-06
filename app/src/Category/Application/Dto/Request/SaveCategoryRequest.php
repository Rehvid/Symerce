<?php

declare(strict_types=1);

namespace App\Category\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\FileData;
use App\Common\Domain\Entity\Category;
use App\Common\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueSlug;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCategoryRequest implements ArrayHydratableInterface
{
    #[Assert\When(
        expression: 'this.id !== null',
        constraints: [
            new Assert\GreaterThan(value: 0)
        ]
    )]
    public ?int $id;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;

    public bool $isActive;

    #[Assert\When(
        expression: 'this.metaTitle !== null',
        constraints: [
            new Assert\Length(min: 2, max: 255),
        ]
    )]
    public ?string $metaTitle;

    #[Assert\When(
        expression: 'this.metaDescription !== null',
        constraints: [
            new Assert\Length(min: 2, max: 500),
        ]
    )]
    public ?string $metaDescription;

    #[Assert\When(
        expression: 'this.slug !== null',
        constraints: [
            new CustomAssertUniqueSlug(options: ['field' => 'slug', 'className' => Category::class]),
            new Assert\Length(min: 2, max: 255),
        ]
    )]
    public ?string $slug;

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
        ?int $id = null
    ) {
        $this->name = $name;
        $this->isActive = $isActive;
        $this->metaTitle = $metaTitle;
        $this->metaDescription = $metaDescription;
        $this->slug = $slug;
        $this->parentCategoryId = $parentCategoryId;
        $this->description = $description;
        $this->fileData = $fileData;
        $this->id = $id;
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
            id: $data['id'] ?? null
        );
    }
}
