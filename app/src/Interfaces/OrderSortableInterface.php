<?php

declare(strict_types=1);

namespace App\Interfaces;

interface OrderSortableInterface
{
    public function getId(): int;

    public function getOrder(): int;

    public function setOrder(int $order): void;
}
