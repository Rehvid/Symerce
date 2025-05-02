<?php

declare(strict_types=1);

namespace App\Mapper\Manager;

use App\Mapper\Interfaces\ResponseMapperInterface;

class ManagerMapperResponse
{
    /**
     * @var ResponseMapperInterface[]
     */
    private array $mappers;

    /**
     * @param iterable<int, ResponseMapperInterface> $mappers
     */
    public function __construct(
        iterable $mappers,
    ) {

        foreach ($mappers as $mapper) {
            $this->mappers[$mapper::class] = $mapper;
        }
    }

    public function get(string $class): ResponseMapperInterface
    {
        if (!isset($this->mappers[$class])) {
            throw new \InvalidArgumentException("Mapper $class not found.");
        }

        return $this->mappers[$class];
    }
}
