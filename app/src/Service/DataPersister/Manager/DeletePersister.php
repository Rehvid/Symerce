<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Manager;

use App\Service\DataPersister\Base\BasePersister;
use App\Service\DataPersister\Interface\DeletePersisterInterface;

final class DeletePersister extends BasePersister
{
    public function delete(object $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}
