<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\Product;

use App\DTO\Admin\Request\Product\SaveProductRequestDTO;
use App\Entity\Product;
use App\Service\DataPersister\Base\UpdatePersister;

final class ProductUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveProductRequestDTO::class, Product::class];
    }
}
