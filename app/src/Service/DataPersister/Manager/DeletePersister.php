<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Manager;

use App\Service\DataPersister\Base\BasePersister;

class DeletePersister extends BasePersister
{
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
