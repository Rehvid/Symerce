<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Shop\Cart;

use App\DTO\Shop\Request\Cart\SaveCartDTO;
use App\Service\DataPersister\Base\CreatePersister;

class CartCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveCartDTO::class];
    }
}
