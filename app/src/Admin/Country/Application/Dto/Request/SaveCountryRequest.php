<?php

declare(strict_types=1);

namespace App\Admin\Country\Application\Dto\Request;

use App\Admin\Domain\Entity\Country;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Shared\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueCode;

final readonly class SaveCountryRequest implements RequestDtoInterface
{
    public ?int $id;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2)]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Length(max: 2)]
    #[CustomAssertUniqueCode(options: ['field' => 'code', 'className' => Country::class])]
    public string $code;

    public bool $isActive;

    public function __construct(
        string $name,
        string $code,
        bool $isActive = false,
        ?int $id = null,
    ) {
        $this->name = $name;
        $this->code = $code;
        $this->isActive = $isActive;
        $this->id = $id;
    }
}
