<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Base;

use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Interface\DataPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;

abstract class AbstractDataPersister implements DataPersisterInterface
{
    public function __construct(
        protected readonly EntityManagerInterface $entityManager
    ) {}


    abstract protected function createEntityFromDto(PersistableInterface $persistable): object;
    abstract protected function updateEntityFromDto(object $entity, PersistableInterface $persistable): object;

    public function persist(PersistableInterface $persistable): object
    {
        if (!$this->isClassSupported($persistable)) {
            throw new LogicException(sprintf(
                "Persistable of type %s is not supported by %s",
                get_class($persistable),
                static::class
            ));
        }

        $entity = $this->createEntityFromDto($persistable);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    public function delete(object $entity): void
    {
        if (!$this->isClassSupported($entity)) {
            throw new LogicException(sprintf(
                "Cannot delete entity. Expected %s, got %s",
                $this->getEntityClass(),
                get_class($entity)
            ));
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    public function update(object $entity, PersistableInterface $persistable): object
    {
        if (!$this->isClassSupported($persistable)) {
            throw new LogicException(sprintf(
                "Persistable of type %s is not supported by %s",
                get_class($persistable),
                static::class
            ));
        }

        if (!$this->isClassSupported($entity)) {
            throw new LogicException(sprintf(
                "Cannot update entity. Expected %s, got %s",
                $this->getEntityClass(),
                get_class($entity)
            ));
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
}
