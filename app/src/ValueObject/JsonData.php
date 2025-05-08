<?php

declare(strict_types=1);

namespace App\ValueObject;

final class JsonData
{
    private array $data;

    private string $rawJson;

    public function __construct(mixed $value)
    {
        if (is_array($value)) {
            $this->setData($value);
            return;
        }

        $this->rawJson = $value;
        $this->data = $this->transformJsonToArray($value);
    }

    public function getRaw(): string
    {
        return $this->rawJson;
    }

    public function getArray(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
        $this->rawJson = $this->transformArrayToJson($data);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }

    private function transformJsonToArray(string $json): array
    {
        try {
            return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException('Invalid JSON format: ' . $e->getMessage(), 0, $e);
        }
    }

    private function transformArrayToJson(array $data): string
    {
        try {
            return json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException('Failed to encode data to JSON: ' . $e->getMessage(), 0, $e);
        }
    }
}
