<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Base;

use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Interface\DataPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;

abstract class AbstractDataPersister implements DataPersisterInterface
{
    public function __construct(
        protected readonly EntityManagerInterface $entityManager
    ) {}

    abstract public function supports(object $persistable): bool;
    abstract protected function createEntityFromDto(PersistableInterface $persistable): object;

    public function persist(PersistableInterface $persistable): object
    {
        $entity = $this->createEntityFromDto($persistable);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}
