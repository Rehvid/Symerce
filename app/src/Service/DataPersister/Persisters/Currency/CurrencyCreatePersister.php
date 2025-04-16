<?php

namespace App\Service\DataPersister\Persisters\Currency;

use App\DTO\Request\Currency\SaveCurrencyRequestDTO;
use App\Entity\Currency;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\CreatePersister;

class CurrencyCreatePersister extends CreatePersister
{

    protected function createEntity(PersistableInterface|SaveCurrencyRequestDTO $persistable): object
    {
        $currency = new Currency();
        $currency->setName($persistable->name);
        $currency->setCode($persistable->code);
        $currency->setSymbol($persistable->symbol);
        $currency->setRoundingPrecision((int) $persistable->roundingPrecision);

        return $currency;
    }

    public function getSupportedClasses(): array
    {
        return [SaveCurrencyRequestDTO::class];
    }
}
