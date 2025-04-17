<?php

declare(strict_types=1);

namespace App\DTO\Request\Carrier;

use App\DTO\Request\PersistableInterface;
use App\Traits\FileRequestMapperTrait;
use Symfony\Component\Validator\Constraints as Assert;

final class SaveCarrierRequestDTO implements PersistableInterface
{
    use FileRequestMapperTrait;

    /**
     * @param array<string, mixed> $image
     *
     * @throws \ReflectionException
     */
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public readonly string $name,
        #[Assert\GreaterThanOrEqual(0)] #[Assert\Type('numeric')] public readonly string $fee, // TODO: Assert precision etc
        public readonly bool $isActive,
        public array $image = []
    ) {
        $this->image = $this->createFileRequestDTOs($this->image);
    }
}
