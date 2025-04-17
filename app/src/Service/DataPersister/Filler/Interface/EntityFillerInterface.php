<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler\Interface;

use App\DTO\Request\PersistableInterface;

interface EntityFillerInterface
{
    public function toNewEntity(PersistableInterface $persistable): object;

    public function toExistingEntity(PersistableInterface $persistable, object $entity): object;

    public static function supports(): string;
}
