<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Category;

use App\DTO\Request\Category\SaveCategoryRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class CategoryCreatePersister extends CreatePersister
{
    /** @return array<int, string> */
    public function getSupportedClasses(): array
    {
        return [SaveCategoryRequestDTO::class];
    }
}
