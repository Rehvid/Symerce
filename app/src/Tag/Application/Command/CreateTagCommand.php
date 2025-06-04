<?php

declare(strict_types=1);

namespace App\Tag\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;
use App\Tag\Application\Dto\TagData;

final readonly class CreateTagCommand implements CommandInterface
{
    public function __construct(
        public TagData $data
    ) {}
}
