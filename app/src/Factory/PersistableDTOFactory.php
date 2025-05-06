<?php

declare(strict_types=1);

namespace App\Factory;

use App\DTO\Admin\Request\PersistableInterface;

final class PersistableDTOFactory
{
    /**
     * @param array<mixed, mixed> $data
     *
     * @throws \ReflectionException
     */
    public static function create(string $dtoClass, array $data): PersistableInterface
    {
        if (!class_exists($dtoClass)) {
            throw new \InvalidArgumentException("Class $dtoClass does not exists.");
        }

        $reflection = new \ReflectionClass($dtoClass);

        if (!$reflection->implementsInterface(PersistableInterface::class)) {
            throw new \InvalidArgumentException("$dtoClass must implementation PersistableInterface.");
        }

        $constructorParams = $reflection->getConstructor()?->getParameters() ?? [];
        $args = [];

        foreach ($constructorParams as $param) {
            $name = $param->getName();
            $args[] = $data[$name] ?? ($param->isOptional() ? $param->getDefaultValue() : null);
        }

        /** @var PersistableInterface $object */
        $object = $reflection->newInstanceArgs($args);

        return $object;
    }
}
