<?php

declare(strict_types=1);

namespace App\Common\Application\Dto;

final readonly class OptionItem
{
    public function __construct(
        public string $label,
        public mixed $value,
    ) {
    }
}
