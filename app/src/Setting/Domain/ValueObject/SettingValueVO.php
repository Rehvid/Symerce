<?php

declare(strict_types=1);

namespace App\Setting\Domain\ValueObject;

use App\Setting\Domain\Enums\SettingValueType;

final class SettingValueVO
{
    private mixed $value;

    private SettingValueType $type;

    public function __construct(SettingValueType $type, mixed $rawValue)
    {
        $this->type = $type;
        $this->value = $this->castRawValue($rawValue);
    }

    private function castRawValue(mixed $rawValue): mixed
    {
        return match ($this->type) {
            SettingValueType::STRING => $rawValue,
            SettingValueType::BOOLEAN => filter_var($rawValue, FILTER_VALIDATE_BOOLEAN),
            SettingValueType::JSON => $this->resolveCastJsonRawValue($rawValue),
            SettingValueType::INTEGER => (int) $rawValue,
            SettingValueType::FLOAT => (float) $rawValue,
        };
    }

    private function resolveCastJsonRawValue(mixed $rawValue): mixed
    {
        if (is_array($rawValue)) {
            return $this->encodeJson($rawValue);
        }

        if (json_validate($rawValue)) {
            return $rawValue;
        }

        return $this->decodeJson($rawValue);
    }

    public function decodeJson(string $json): mixed
    {
        try {
            return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return null;
        }
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getRawValue(): string
    {
        return match ($this->type) {
            SettingValueType::STRING => (string) $this->value,
            SettingValueType::BOOLEAN => $this->value ? '1' : '0',
            SettingValueType::JSON => $this->resolveCastValueToRawValueJson($this->value),
            SettingValueType::INTEGER => (string) (int) $this->value,
            SettingValueType::FLOAT => (string) (float) $this->value,
        };
    }

    private function resolveCastValueToRawValueJson(mixed $rawValue): mixed
    {
        if (json_validate($rawValue)) {
            return $rawValue;
        }

        return $this->encodeJson($this->value);
    }

    private function encodeJson(mixed $value): string
    {
        try {
            return json_encode($value, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return '{}';
        }
    }

    public function getType(): SettingValueType
    {
        return $this->type;
    }

    public static function from(mixed $value, SettingValueType $type): self
    {
        $rawValue = match ($type) {
            SettingValueType::STRING => (string) $value,
            SettingValueType::BOOLEAN => $value ? '1' : '0',
            SettingValueType::JSON => (string) (new self($type, ''))->encodeJson($value),
            SettingValueType::INTEGER => (string) (int) $value,
            SettingValueType::FLOAT => (string) (float) $value,
        };

        return new self($type, $rawValue);
    }

    public function __toString(): string
    {
        return $this->getRawValue();
    }
}
