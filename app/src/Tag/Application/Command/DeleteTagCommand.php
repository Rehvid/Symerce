<?php

declare(strict_types=1);

namespace App\Tag\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;

final readonly class DeleteTagCommand implements CommandInterface
{
    public function __construct(public int $tagId)
    {
    }
}
