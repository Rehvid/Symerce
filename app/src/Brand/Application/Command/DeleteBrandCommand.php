<?php

declare(strict_types=1);

namespace App\Brand\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;

final readonly class DeleteBrandCommand implements CommandInterface
{
    public function __construct(public int $brandId) {}
}
