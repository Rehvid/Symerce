<?php

declare(strict_types=1);

namespace App\AdminEntry\Infrastructure\DataProvider;

use App\AdminEntry\Application\Contract\ReactDataProviderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final readonly class AppConfigProvider implements ReactDataProviderInterface
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
    ) {
    }

    public function getData(): array
    {
        return [
            'baseUrl' => is_string($this->parameterBag->get('app.base_url')) ? $this->parameterBag->get('app.base_url') : '',
        ];
    }

    public function getName(): string
    {
        return 'config';
    }
}
