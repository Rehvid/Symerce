<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Manager;

use App\DTO\Request\PersistableInterface;
use App\Service\DataPersister\Interface\CreatePersisterInterface;
use App\Service\DataPersister\Interface\UpdatePersisterInterface;

class PersisterManager
{
    /**
     * @var CreatePersisterInterface[]
     */
    private array $createPersisters;

    /**
     * @var UpdatePersisterInterface[]
     */
    private array $updatePersisters;

    private readonly DeletePersister $deletePersister;

    /**
     * @param iterable<int, CreatePersisterInterface> $createPersisters
     * @param iterable<int, UpdatePersisterInterface> $updatePersisters
     */
    public function __construct(
        iterable $createPersisters,
        iterable $updatePersisters,
        DeletePersister $deletePersister
    ) {

        foreach ($createPersisters as $persister) {
            foreach ($persister->getSupportedClasses() as $class) {
                $this->createPersisters[$class] = $persister;
            }
        }

        foreach ($updatePersisters as $persister) {
            foreach ($persister->getSupportedClasses() as $class) {
                $this->updatePersisters[$class] = $persister;
            }
        }

        $this->deletePersister = $deletePersister;
    }

    private function getUpdatePersister(object|string $data): UpdatePersisterInterface
    {
        $class = is_object($data) ? get_class($data) : $data;

        return $this->updatePersisters[$class] ?? throw new \LogicException("No persister found for $class");
    }

    private function getCreatePersister(object|string $data): CreatePersisterInterface
    {
        $class = is_object($data) ? get_class($data) : $data;

        return $this->createPersisters[$class] ?? throw new \LogicException("No persister found for $class");
    }

    public function persist(PersistableInterface $data): object
    {
        return $this->getCreatePersister($data)->persist($data);
    }

    public function update(PersistableInterface $persistable, object $entity): object
    {
        return $this->getUpdatePersister($persistable)->update($persistable, $entity);
    }

    public function delete(object $entity): void
    {
        $this->deletePersister->delete($entity);
    }

    /**
     * @param iterable<int, object> $entities
     */
    public function deleteCollection(iterable $entities): void
    {
        $this->deletePersister->deleteCollection($entities);
    }
}
