<?php

declare(strict_types=1);

namespace App\Category\Domain\Service;

use App\Common\Domain\Entity\Category;

interface CategoryTreeBuilderInterface
{
    public function generateTree(?Category $currentCategory = null): array;
}
