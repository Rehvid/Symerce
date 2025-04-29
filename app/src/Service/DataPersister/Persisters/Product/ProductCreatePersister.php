<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Product;

use App\DTO\Request\Product\SaveProductRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class ProductCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveProductRequestDTO::class];
    }
}
