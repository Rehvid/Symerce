<?php

namespace App\Service\DataPersister\Persisters\Currency;

use App\DTO\Request\Currency\SaveCurrencyRequestDTO;
use App\Entity\Currency;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\UpdatePersister;

class CurrencyUpdatePersister extends UpdatePersister
{

    /**
     * @param object|Currency $entity
     */
    protected function updateEntity(PersistableInterface|SaveCurrencyRequestDTO $persistable, object $entity): Currency
    {
        $entity->setName($persistable->name);
        $entity->setCode($persistable->code);
        $entity->setSymbol($persistable->symbol);
        $entity->setRoundingPrecision((int) $persistable->roundingPrecision);

        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [SaveCurrencyRequestDTO::class, Currency::class];
    }
}
