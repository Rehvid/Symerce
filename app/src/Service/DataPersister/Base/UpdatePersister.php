<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Base;

use App\Exceptions\PersisterException;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Interface\UpdatePersisterInterface;

abstract class UpdatePersister extends BasePersister implements UpdatePersisterInterface
{
    /**
     * @throws PersisterException
     */
    public function update(PersistableInterface $persistable, object $entity): object
    {
        $this->ensureUpdateHasValidClasses($persistable, $entity);

        $updatedEntity = $this->updateEntity($persistable, $entity);

        $this->save($updatedEntity);

        return $updatedEntity;
    }

    /**
     * @throws PersisterException
     */
    private function ensureUpdateHasValidClasses(PersistableInterface $persistable, object $entity): void
    {
        if (!$this->isClassSupported($persistable, $this->getSupportedClasses())) {
            throw new PersisterException($this->buildUnsupportedPersistableMessage($persistable));
        }

        if (!$this->isClassSupported($entity, $this->getSupportedClasses())) {
            throw new PersisterException($this->buildUnsupportedClassesExceptionMessage($entity, $this->getSupportedClasses()));
        }
    }

    abstract protected function updateEntity(PersistableInterface $persistable, object $entity): object;

    /** @return array<int, string> */
    abstract public function getSupportedClasses(): array;
}
