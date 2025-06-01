<?php

declare(strict_types=1);

namespace App\Admin\Domain\Contract;

interface PositionEntityInterface
{
    public function getPosition(): int;

    public function setPosition(int $order): void;
}
