<?php

declare(strict_types=1);

namespace App\Admin\Application\Provider;

use App\Admin\Application\Contract\ReactDataProviderInterface;

final readonly class ReactDataProvider
{
    /** @var iterable<ReactDataProviderInterface>  */
    private iterable $providers;

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
