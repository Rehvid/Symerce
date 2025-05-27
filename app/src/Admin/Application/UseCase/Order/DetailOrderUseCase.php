<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Order;

use App\Admin\Application\Assembler\OrderAssembler;
use App\Shared\Domain\Entity\Order;

final readonly class DetailOrderUseCase
{
    public function __construct(
         private OrderAssembler $assembler,
    ) {}

    public function execute(Order $order): array
    {
        return $this->assembler->toDetailResponse($order);
    }
}
