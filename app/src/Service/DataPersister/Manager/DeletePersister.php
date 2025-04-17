<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Manager;

use Doctrine\ORM\EntityManagerInterface;

final class DeletePersister
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function delete(object $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * @param iterable<int, object> $entities
     */
    public function deleteCollection(iterable $entities): void
    {
        foreach ($entities as $entity) {
            $this->entityManager->remove($entity);
        }

        $this->entityManager->flush();
    }
}
