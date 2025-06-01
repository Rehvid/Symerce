<?php

declare(strict_types=1);

namespace App\Brand\Application\Dto\Request;

use App\Admin\Domain\Model\FileData;
use App\Shared\Application\Contract\ArrayHydratableInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveBrandRequest implements ArrayHydratableInterface, RequestDtoInterface
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
