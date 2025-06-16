<?php

declare(strict_types=1);

namespace App\AdminEntry\Application\Provider;

use App\AdminEntry\Application\Contract\ReactDataProviderInterface;

final readonly class ReactDataProvider
{
    /** @var iterable<ReactDataProviderInterface> */
    private iterable $providers;

    /**
     * @param array<mixed,mixed> $providers
     */
    public function __construct(iterable $providers)
    {
        $this->providers = $providers;
    }

    public function provide(): array
    {
        $result = [];
        foreach ($this->providers as $provider) {
            $result[$provider->getName()] = $provider->getData();
        }

        return $result;
    }
}
