<?php

declare(strict_types=1);

namespace App\Brand\Application\Command;

use App\Shared\Application\Command\CommandInterface;

final readonly class DeleteBrandCommand implements CommandInterface
{
    public function __construct(public int $brandId) {}
}
