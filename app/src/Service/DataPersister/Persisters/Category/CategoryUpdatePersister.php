<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Category;

use App\DTO\Request\Category\SaveCategoryRequestDTO;
use App\Entity\Category;
use App\Service\DataPersister\Base\UpdatePersister;

final class CategoryUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveCategoryRequestDTO::class, Category::class];
    }
}
