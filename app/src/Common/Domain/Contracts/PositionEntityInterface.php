<?php

declare(strict_types=1);

namespace App\Common\Domain\Contracts;

interface PositionEntityInterface
{
    public function getPosition(): int;

    public function setPosition(int $order): void;
}
