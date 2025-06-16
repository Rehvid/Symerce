<?php

declare(strict_types=1);

namespace App\Category\Application\Dto\Request;

use App\Common\Application\Dto\FileData;
use App\Common\Application\Dto\Request\IdRequest;
use App\Common\Domain\Entity\Category;
use App\Common\Infrastructure\Utils\BoolHelper;
use App\Common\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueSlug;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCategoryRequest
{
    #[Assert\Valid]
    public IdRequest $idRequest;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;

    #[Assert\When(
        expression: 'this.metaTitle !== null and this.metaTitle != ""',
        constraints: [
            new Assert\Length(min: 2, max: 255),
        ]
    )]
    public ?string $metaTitle;

    #[Assert\When(
        expression: 'this.metaDescription !== null and this.metaDescription != ""',
        constraints: [
            new Assert\Length(min: 2, max: 500),
        ]
    )]
    public ?string $metaDescription;

    #[Assert\When(
        expression: 'this.slug !== null and this.slug != ""',
        constraints: [
            new CustomAssertUniqueSlug(options: ['field' => 'slug', 'className' => Category::class]),
            new Assert\Length(min: 2, max: 255),
        ]
    )]
    public ?string $slug;


    #[Assert\Valid]
    public IdRequest $parentCategoryIdRequest;


    #[Assert\When(
        expression: 'this.description !== null and this.description != ""',
        constraints: [
            new Assert\Length(min: 2),
        ]
    )]
    public ?string $description;

    #[Assert\Valid]
    public ?FileData $fileData;


    public bool $isActive;


    /** @param array<string,mixed> $thumbnail */
    public function __construct(
        null|int|string $id,
        string $name,
        ?string $metaTitle,
        ?string $metaDescription,
        ?string $slug,
        null|int|string $parentCategoryId,
        ?string $description,
        ?array $thumbnail,
        mixed $isActive,
    ) {
        $this->name = $name;
        $this->isActive = BoolHelper::castOrFail($isActive, 'isActive');
        $this->metaTitle = $metaTitle;
        $this->metaDescription = $metaDescription;
        $this->slug = $slug;
        $this->parentCategoryIdRequest = new IdRequest($parentCategoryId);
        $this->description = $description;
        $this->fileData = $thumbnail ? FileData::fromArray($thumbnail) : null;
        $this->idRequest = new IdRequest($id);
    }
}
