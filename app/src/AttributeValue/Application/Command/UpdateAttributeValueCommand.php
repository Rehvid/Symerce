<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Command;

use App\AttributeValue\Application\Dto\AttributeValueData;
use App\Common\Application\Command\Interfaces\CommandInterface;

final readonly class UpdateAttributeValueCommand implements CommandInterface
{
    public function __construct(
        public int $attributeValueId,
        public AttributeValueData $data,
    ) {}
}
