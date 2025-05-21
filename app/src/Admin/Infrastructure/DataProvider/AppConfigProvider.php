<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\DataProvider;

use App\Admin\Application\Contract\ReactDataProviderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

readonly class AppConfigProvider implements ReactDataProviderInterface
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
    ) {
    }


    public function getData(): array
    {
        return [
            'baseUrl' => $this->parameterBag->get('app.base_url'),
        ];
    }

    public function getName(): string
    {
        return 'config';
    }
}
