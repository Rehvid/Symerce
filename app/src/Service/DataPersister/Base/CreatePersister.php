<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Base;

use App\DTO\Admin\Request\PersistableInterface;
use App\Exceptions\PersisterException;
use App\Service\DataPersister\Interface\CreatePersisterInterface;

abstract class CreatePersister extends BasePersister implements CreatePersisterInterface
{
    /**
     * @throws PersisterException
     */
    public function persist(PersistableInterface $persistable): object
    {
        $this->ensureCreateHasValidClasses($persistable);

        $filler = $this->fillerResolver->getFillerFor($persistable);

        $entity = $filler->toNewEntity($persistable);

        $this->save($entity);

        return $entity;
    }

    /**
     * @throws PersisterException
     */
    private function ensureCreateHasValidClasses(PersistableInterface $persistable): void
    {
        if (!$this->isClassSupported($persistable, $this->getSupportedClasses())) {
            throw new PersisterException($this->buildUnsupportedPersistableMessage($persistable));
        }
    }

    abstract public function getSupportedClasses(): array;
}
