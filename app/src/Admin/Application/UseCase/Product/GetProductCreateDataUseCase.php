<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Product;

use App\Admin\Application\Assembler\ProductAssembler;
use App\Shared\Application\UseCases\Base\QueryUseCaseInterface;

final readonly class GetProductCreateDataUseCase implements QueryUseCaseInterface
{
    public function __construct(
        private ProductAssembler $assembler
    ) {
    }

    public function execute(): mixed
    {
        return $this->assembler->toCreateFormDataResponse();
    }
}
