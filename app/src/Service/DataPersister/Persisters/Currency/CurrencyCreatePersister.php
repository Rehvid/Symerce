<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Currency;

use App\DTO\Request\Currency\SaveCurrencyRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class CurrencyCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveCurrencyRequestDTO::class];
    }
}
