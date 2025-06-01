<?php

declare(strict_types=1);

namespace App\Carrier\Application\Command;

use App\Carrier\Application\Dto\CarrierData;
use App\Shared\Application\Command\CommandInterface;

final readonly class UpdateCarrierCommand implements CommandInterface
{
    public function __construct(
        public CarrierData $data,
        public int $carrierId,
    ) {}
}
