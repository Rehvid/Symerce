<?php

declare(strict_types=1);

namespace App\Brand\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\FileData;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveBrandRequest implements ArrayHydratableInterface
{
    private function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $name,
        public bool $isActive,
        public ?FileData $fileData = null,
    ) {
    }

    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $thumbnail = $data['thumbnail'] ?? null;
        $fileData = null;
        if (!empty($thumbnail)) {
            $fileData = FileData::fromArray($thumbnail[0]);
        }

        return new self(
            name: $data['name'],
            isActive: $data['isActive'],
            fileData: $fileData,
        );
    }
}
