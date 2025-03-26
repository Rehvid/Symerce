<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Base;

use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Interface\DataPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractDataPersister implements DataPersisterInterface
{
    private const string ACTION_DELETE = 'delete';
    private const string ACTION_UPDATE = 'update';

    public function __construct(
        protected readonly EntityManagerInterface $entityManager
    ) {
    }

    abstract protected function createEntityFromDto(PersistableInterface $persistable): object;

    abstract protected function updateEntityFromDto(object $entity, PersistableInterface $persistable): object;

    public function persist(PersistableInterface $persistable): object
    {
        if (!$this->isClassSupported($persistable)) {
            throw new \LogicException($this->getUnsupportedPersistableClassesExceptionMessage($persistable));
        }

        $entity = $this->createEntityFromDto($persistable);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    public function delete(object $entity): void
    {
        if (!$this->isClassSupported($entity)) {
            throw new \LogicException($this->getUnsupportedEntityClassesExceptionMessage(self::ACTION_DELETE, $entity));
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    public function update(object $entity, PersistableInterface $persistable): object
    {
        if (!$this->isClassSupported($persistable)) {
            throw new \LogicException($this->getUnsupportedPersistableClassesExceptionMessage($persistable));
        }

        if (!$this->isClassSupported($entity)) {
            throw new \LogicException($this->getUnsupportedEntityClassesExceptionMessage(self::ACTION_UPDATE, $entity));
        }

        $entity = $this->updateEntityFromDto($entity, $persistable);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    private function isClassSupported(object $class): bool
    {
        return in_array(get_class($class), $this->getSupportedClasses(), true);
    }

    private function getUnsupportedEntityClassesExceptionMessage($action, object $entity): string
    {
        return sprintf(
            '%s . Expected one of the following supported classes: %s, got %s.',
            self::ACTION_UPDATE === $action ? 'Cannot update entity' : 'Cannot delete entity',
            implode(', ', $this->getSupportedClasses()),
            get_class($entity)
        );
    }

    private function getUnsupportedPersistableClassesExceptionMessage(PersistableInterface $persistable): string
    {
        return sprintf(
            'Persistable of type %s is not supported by %s',
            get_class($persistable),
            static::class
        );
    }
}
