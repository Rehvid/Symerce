<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Order;

use App\Admin\Application\Assembler\OrderAssembler;
use App\Shared\Application\UseCases\Base\QueryUseCaseInterface;

final readonly class GetOrderCreateDataUseCase implements QueryUseCaseInterface
{
    public function __construct(
        private OrderAssembler $assembler
    ) {}


    public function execute(): mixed
    {
        return $this->assembler->toCreateFormResponse();
    }
}
