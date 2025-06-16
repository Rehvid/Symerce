<?php

declare(strict_types=1);

namespace App\Category\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;

final readonly class DeleteCategoryCommand implements CommandInterface
{
    public function __construct(
        public int $categoryId
    ) {
    }
}
