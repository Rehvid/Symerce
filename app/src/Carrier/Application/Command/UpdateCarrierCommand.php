<?php

declare(strict_types=1);

namespace App\Carrier\Application\Command;

use App\Carrier\Application\Dto\CarrierData;
use App\Common\Application\Command\Interfaces\CommandInterface;

final readonly class UpdateCarrierCommand implements CommandInterface
{
    public function __construct(
        public CarrierData $data,
        public int $carrierId,
    ) {}
}
