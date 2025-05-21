<?php

declare(strict_types=1);

namespace App\Admin\Domain\Contract;

interface OrderEntityInterface
{
    public function getOrder(): int;

    public function setOrder(int $order): void;
}
