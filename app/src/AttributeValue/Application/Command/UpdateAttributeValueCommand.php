<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Command;

use App\AttributeValue\Application\Dto\AttributeValueData;
use App\Shared\Application\Command\CommandInterface;

final readonly class UpdateAttributeValueCommand implements CommandInterface
{
    public function __construct(
        public int $attributeValueId,
        public AttributeValueData $data,
    ) {}
}
