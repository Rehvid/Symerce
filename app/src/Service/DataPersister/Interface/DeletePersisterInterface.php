<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Interface;

interface DeletePersisterInterface
{
    public function delete(object $entity): void;
}
