<?php

declare(strict_types=1);

namespace App\Category\Application\Command;

use App\Category\Application\Dto\CategoryData;
use App\Shared\Application\Command\CommandInterface;

final readonly class UpdateCategoryCommand implements CommandInterface
{
    public function __construct(
        public CategoryData $data,
        public int $categoryId
    ) {

    }
}
