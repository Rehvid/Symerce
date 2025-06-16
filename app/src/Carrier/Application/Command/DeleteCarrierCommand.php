<?php

declare(strict_types=1);

namespace App\Carrier\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;

final readonly class DeleteCarrierCommand implements CommandInterface
{
    public function __construct(public int $carrierId)
    {
    }
}
