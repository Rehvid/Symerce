<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Exception;

final class InvalidBooleanValueException extends \InvalidArgumentException
{
    private string $fieldName;
    private mixed $value;

    public function __construct(string $fieldName, mixed $value)
    {
        $this->fieldName = $fieldName;
        $this->value = $value;

        parent::__construct(sprintf(
            'Must be a boolean-like value (true/false, 1/0, "yes"/"no"). Got: %s',
            var_export($value, true)
        ));
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}
