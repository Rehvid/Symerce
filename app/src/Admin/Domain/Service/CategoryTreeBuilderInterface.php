<?php

declare(strict_types=1);

namespace App\Admin\Domain\Service;

use App\Entity\Category;

interface CategoryTreeBuilderInterface
{
    public function generateTree(?Category $currentCategory = null): array;
}
