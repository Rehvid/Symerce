<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Base;

use App\Interfaces\PersistableInterface;
use Doctrine\ORM\EntityManagerInterface;

abstract class BasePersister
{
    public function __construct(
        protected readonly EntityManagerInterface $entityManager
    ) {}

    protected function isClassSupported(object $class, array $supportedClasses): bool
    {
        return in_array(get_class($class), $supportedClasses, true);
    }

    protected function buildUnsupportedClassesExceptionMessage(object $entity, array $supportedClasses): string
    {
        return sprintf(
            '%s . Expected one of the following supported classes: %s, got %s.',
            'Cannot update entity',
            implode(', ', $supportedClasses),
            get_class($entity)
        );
    }

    protected function buildUnsupportedPersistableMessage(PersistableInterface $persistable): string
    {
        return sprintf(
            'Persistable of type %s is not supported by %s',
            get_class($persistable),
            static::class
        );
    }
}
