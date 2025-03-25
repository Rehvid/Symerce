<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Manager;

use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Interface\DataPersisterInterface;

class DataPersisterManager
{
    /**
     * @var DataPersisterInterface[]
     */
    private array $persisters;

    public function __construct(iterable $persisters)
    {
        $this->persisters = is_array($persisters) ? $persisters : iterator_to_array($persisters);
    }

    public function persist(PersistableInterface $data): object
    {
        foreach ($this->persisters as $persister) {
            if ($persister->supports($data)) {
                return $persister->persist($data);
            }
        }

        throw new \InvalidArgumentException('Persistence does not exist for provided data.');
    }
}
