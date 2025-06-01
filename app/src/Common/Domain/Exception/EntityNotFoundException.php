<?php

declare(strict_types=1);

namespace App\Common\Domain\Exception;

final class EntityNotFoundException extends \RuntimeException
{
    public static function for(string $entityName, string|int $id): self
    {
        return new self(sprintf('%s with ID %s not found.', $entityName, $id));
    }
}
