<?php

declare(strict_types=1);

namespace App\Country\Application\Dto\Request;

use App\Common\Application\Dto\Request\IdRequest;
use App\Common\Domain\Entity\Country;
use App\Common\Infrastructure\Utils\BoolHelper;
use App\Common\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueField;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCountryRequest
{
    #[Assert\Valid]
    public IdRequest $idRequest;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    #[CustomAssertUniqueField(options: ['field' => 'name', 'className' => Country::class])]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Length(min:2, max: 2)]
    #[CustomAssertUniqueField(options: ['field' => 'code', 'className' => Country::class])]
    public string $code;

    public bool $isActive;

    public function __construct(
        int|string|null $id,
        string $name,
        string $code,
        mixed $isActive,
    ) {
        $this->idRequest = new IdRequest($id);
        $this->name = $name;
        $this->code = $code;
        $this->isActive = BoolHelper::castOrFail($isActive, 'isActive');
    }
}
