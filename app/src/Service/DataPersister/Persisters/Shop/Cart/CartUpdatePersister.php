<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Shop\Cart;

use App\DTO\Shop\Request\Cart\SaveCartDTO;
use App\Entity\Cart;
use App\Service\DataPersister\Base\UpdatePersister;

class CartUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveCartDTO::class, Cart::class];
    }
}
