<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler\Base;

use App\DTO\Admin\Request\PersistableInterface;
use App\Service\DataPersister\Filler\Interface\EntityFillerInterface;

/**
 * @template T of PersistableInterface
 */
abstract class BaseEntityFiller implements EntityFillerInterface
{
    /**
     * @param T $persistable
     */
    abstract public function toNewEntity(PersistableInterface $persistable): object;

    /**
     * @param T $persistable
     */
    abstract public function toExistingEntity(PersistableInterface $persistable, object $entity): object;

    abstract public static function supports(): string;

    /**
     * @param T $persistable
     */
    abstract protected function fillEntity(PersistableInterface $persistable, object $entity): object;
}
