<?php

declare(strict_types=1);

namespace App\Attribute\Application\Command;

use App\Attribute\Application\Dto\AttributeData;
use App\Common\Application\Command\Interfaces\CommandInterface;

final readonly class CreateAttributeCommand implements CommandInterface
{
    public function __construct(
        public AttributeData $data
    ) {
    }
}
