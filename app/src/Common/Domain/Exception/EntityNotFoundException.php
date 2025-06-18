<?php

declare(strict_types=1);

namespace App\Common\Domain\Exception;

final class EntityNotFoundException extends \RuntimeException
{
    public static function for(string $entityName, string|int|null $id): self
    {
        return new self(sprintf('%s with ID %s not found.', $entityName, $id));
    }

    public static function forField(string $entityName, string $fieldName, string|int|null $value): self
    {
        return new self(sprintf('%s with %s "%s" not found.', $entityName, $fieldName, (string) $value));
    }
}
