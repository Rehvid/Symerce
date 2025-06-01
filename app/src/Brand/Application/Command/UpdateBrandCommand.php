<?php

declare(strict_types=1);

namespace App\Brand\Application\Command;

use App\Brand\Application\Dto\BrandData;
use App\Shared\Application\Command\CommandInterface;

final readonly class UpdateBrandCommand implements CommandInterface
{
    public function __construct(
        public BrandData $data,
        public int $brandId,
    ) {}
}
