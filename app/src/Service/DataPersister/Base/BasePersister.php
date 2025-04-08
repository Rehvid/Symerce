<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Base;

use App\Interfaces\PersistableInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Proxy;

abstract class BasePersister
{
    public function __construct(
        protected readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @param array<int, string> $supportedClasses
     */
    protected function isClassSupported(object $class, array $supportedClasses): bool
    {
        $className = get_class($class);
        if ($class instanceof Proxy) {
            $className = get_parent_class($class);
        }

        return in_array($className, $supportedClasses, true);
    }

    /**
     * @param array<int, string> $supportedClasses
     */
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
