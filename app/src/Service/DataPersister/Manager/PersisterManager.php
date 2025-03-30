<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Manager;

use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Interface\CreatePersisterInterface;
use App\Service\DataPersister\Interface\DataPersisterInterface;
use App\Service\DataPersister\Interface\DeletePersisterInterface;
use App\Service\DataPersister\Interface\UpdatePersisterInterface;

final class PersisterManager
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

    public function __construct(
        iterable $createPersisters,
        iterable $updatePersisters,
        DeletePersister $deletePersister
    )
    {
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
}
