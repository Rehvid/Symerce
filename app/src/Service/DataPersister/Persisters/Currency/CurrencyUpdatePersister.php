<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Currency;

use App\DTO\Request\Currency\SaveCurrencyRequestDTO;
use App\Entity\Currency;
use App\Service\DataPersister\Base\UpdatePersister;

final class CurrencyUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveCurrencyRequestDTO::class, Currency::class];
    }
}
