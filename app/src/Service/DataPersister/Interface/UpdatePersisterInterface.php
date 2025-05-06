<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Interface;

use App\DTO\Admin\Request\PersistableInterface;

interface UpdatePersisterInterface extends DataPersisterInterface
{
    public function update(PersistableInterface $persistable, object $entity): object;
}
