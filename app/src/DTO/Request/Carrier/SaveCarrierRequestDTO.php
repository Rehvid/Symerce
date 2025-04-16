<?php

declare(strict_types=1);

namespace App\DTO\Request\Carrier;

use App\Interfaces\PersistableInterface;
use App\Traits\FileTransformerTrait;

use Symfony\Component\Validator\Constraints as Assert;

class SaveCarrierRequestDTO implements PersistableInterface
{
    use FileTransformerTrait;

    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public readonly string $name,
        #[Assert\NotBlank] public readonly string $fee,
        public readonly bool $isActive,
        public array $image = []
    ){
        $this->image = $this->transformToFileRequestDTO($this->image);
    }
}
