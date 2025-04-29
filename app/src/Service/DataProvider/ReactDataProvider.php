<?php

declare(strict_types=1);

namespace App\Service\DataProvider;

use App\Service\DataProvider\Interface\ReactDataInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class ReactDataProvider
{
    /** @var array<string,mixed> */
    private array $result = [];

    public function __construct()
    {
    }

    public function getData(): string
    {
        try {
            return json_encode(value: $this->result, flags: JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            throw new UnprocessableEntityHttpException("Cannot convert to JSON string while trying to encode data. Error: {$e->getMessage()}");
        }
    }

    public function add(ReactDataInterface $item): void
    {
        $this->result[$item->getName()] = $item->getData();
    }
}
