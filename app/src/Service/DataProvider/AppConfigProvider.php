<?php

declare(strict_types=1);

namespace App\Service\DataProvider;

use App\Service\DataProvider\Interface\ReactDataInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

readonly class AppConfigProvider implements ReactDataInterface
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
