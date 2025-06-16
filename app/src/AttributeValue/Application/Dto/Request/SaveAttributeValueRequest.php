<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Dto\Request;

use App\Common\Application\Dto\Request\IdRequest;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveAttributeValueRequest
{
    #[Assert\Length(min: 1, max: 255)]
    public string $value;

    #[Assert\Valid]
    public IdRequest $attributeIdRequest;

    public function __construct(
        string $value,
        int|string|null $attributeId
    ) {
        $this->value = $value;
        $this->attributeIdRequest = new IdRequest($attributeId);
    }
}
