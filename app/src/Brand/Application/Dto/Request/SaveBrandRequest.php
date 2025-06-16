<?php

declare(strict_types=1);

namespace App\Brand\Application\Dto\Request;

use App\Common\Application\Dto\FileData;
use App\Common\Infrastructure\Utils\BoolHelper;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveBrandRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;

    #[Assert\Valid]
    public ?FileData $fileData;

    public bool $isActive;

    /** @param array<string, mixed> $thumbnail */
    public function __construct(
        string $name,
        mixed $isActive,
        ?array $thumbnail,
    ) {
        $this->name = $name;
        $this->isActive = BoolHelper::castOrFail($isActive, 'isActive');
        $this->fileData = $thumbnail ? FileData::fromArray($thumbnail) : null;
    }
}
