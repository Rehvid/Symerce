<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\Vendor;

use App\Admin\Domain\Model\FileData;
use App\Shared\Application\Contract\ArrayHydratableInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveVendorRequest implements ArrayHydratableInterface, RequestDtoInterface
{
    private function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public string $name,
        public bool $isActive,
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
            fileData: $fileData,
        );
    }
}
