<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\Product;

use App\DTO\Admin\Request\Product\SaveProductRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class ProductCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveProductRequestDTO::class];
    }
}
