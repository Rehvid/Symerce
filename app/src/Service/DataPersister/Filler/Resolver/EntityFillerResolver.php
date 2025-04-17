<?php

namespace App\Service\DataPersister\Filler\Resolver;

use App\DTO\Request\PersistableInterface;
use App\Service\DataPersister\Filler\Interface\EntityFillerInterface;

final class EntityFillerResolver
{
    /** @var array<string, EntityFillerInterface> */
    private array $map = [];

    /**
     * @param iterable<EntityFillerInterface> $fillers
     */
    public function __construct(iterable $fillers)
    {
        foreach ($fillers as $filler) {
            $this->map[$filler::supports()] = $filler;
        }
    }

    public function getFillerFor(PersistableInterface $dto): EntityFillerInterface
    {
        $dtoClass = get_class($dto);

        if (!isset($this->map[$dtoClass])) {
            throw new \RuntimeException("No filler found for DTO $dtoClass");
        }

        return $this->map[$dtoClass];
    }
}
