<?php

declare(strict_types=1);

namespace App\Brand\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\FileData;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveBrandRequest implements ArrayHydratableInterface
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;

    public bool $isActive;

    public ?FileData $fileData;

    private function __construct(
        string $name,
        bool $isActive,
        ?FileData $fileData = null,
    ) {
        $this->name = $name;
        $this->isActive = $isActive;
        $this->fileData = $fileData;
    }

    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $thumbnail = $data['thumbnail'] ?? null;
        return new self(
            name: $data['name'],
            isActive: $data['isActive'],
            fileData: $thumbnail ? FileData::fromArray($thumbnail) : null
        );
    }
}
