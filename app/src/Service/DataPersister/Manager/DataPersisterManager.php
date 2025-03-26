<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Manager;

use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Interface\DataPersisterInterface;
use LogicException;

class DataPersisterManager
{
    /**
     * @var DataPersisterInterface[]
     */
    private array $persisters;


    public function __construct(iterable $persisters)
    {
        foreach ($persisters as $persister) {
            foreach ($persister->getSupportedClasses() as $class) {
                $this->persisters[$class] = $persister;
            }
        }
    }

    private function getPersister(object|string $data): DataPersisterInterface
    {
        $class = is_object($data) ? get_class($data) : $data;

        return $this->persisters[$class] ?? throw new LogicException("No persister found for $class");
    }

    public function persist(PersistableInterface $data): object
    {
        return $this->getPersister($data)->persist($data);
    }

    public function update(object $entity, PersistableInterface $data): object
    {
        return $this->getPersister($data)->update($entity, $data);
    }

    public function delete(object $entity): void
    {
        $this->getPersister($entity)->delete($entity);
    }
}
