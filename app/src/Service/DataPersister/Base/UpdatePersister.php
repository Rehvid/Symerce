<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Base;

use App\DTO\Admin\Request\PersistableInterface;
use App\Exceptions\PersisterException;
use App\Service\DataPersister\Interface\UpdatePersisterInterface;

abstract class UpdatePersister extends BasePersister implements UpdatePersisterInterface
{
    /**
     * @throws PersisterException
     */
    public function update(PersistableInterface $persistable, object $entity): object
    {
        $this->ensureUpdateHasValidClasses($persistable, $entity);

        $filler = $this->fillerResolver->getFillerFor($persistable);

        $updatedEntity = $filler->toExistingEntity($persistable, $entity);

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

    /** @return array<int, string> */
    abstract public function getSupportedClasses(): array;
}
