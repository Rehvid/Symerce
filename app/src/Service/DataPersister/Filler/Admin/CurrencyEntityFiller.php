<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler\Admin;

use App\DTO\Admin\Request\Currency\SaveCurrencyRequestDTO;
use App\DTO\Admin\Request\PersistableInterface;
use App\Entity\Currency;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;

/**
 * @extends BaseEntityFiller<SaveCurrencyRequestDTO>
 */
final class CurrencyEntityFiller extends BaseEntityFiller
{
    public function toNewEntity(PersistableInterface $persistable): Currency
    {
        return $this->fillEntity($persistable, new Currency());
    }

    /**
     * @param Currency $entity
     */
    public function toExistingEntity(PersistableInterface $persistable, object $entity): Currency
    {
        return $this->fillEntity($persistable, $entity);
    }

    public static function supports(): string
    {
        return SaveCurrencyRequestDTO::class;
    }

    /**
     * @param Currency $entity
     */
    protected function fillEntity(PersistableInterface|SaveCurrencyRequestDTO $persistable, object $entity): Currency
    {
        $entity->setName($persistable->name);
        $entity->setCode($persistable->code);
        $entity->setSymbol($persistable->symbol);
        $entity->setRoundingPrecision((int) $persistable->roundingPrecision);

        return $entity;
    }
}
