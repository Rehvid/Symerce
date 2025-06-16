<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Utils;

use App\Common\Infrastructure\Exception\InvalidBooleanValueException;

final readonly class BoolHelper
{
    public static function castOrFail(mixed $value, string $fieldName = 'value'): bool
    {
        $bool = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if (!is_bool($bool)) {
            throw new InvalidBooleanValueException($fieldName, $value);
        }

        return $bool;
    }
}
