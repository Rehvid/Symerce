<?php

declare(strict_types=1);

namespace App\Admin\Country\Application\Command;

use App\Admin\Domain\Entity\Country;
use App\Shared\Application\Command\CommandInterface;

final readonly class DeleteCountryCommand implements CommandInterface
{
    public function __construct(
        public Country $country
    ) {}
}
