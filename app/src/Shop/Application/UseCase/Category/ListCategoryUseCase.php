<?php

declare (strict_types = 1);

namespace App\Shop\Application\UseCase\Category;

use App\Shared\Application\UseCases\Base\QueryUseCaseInterface;
use App\Shop\Application\Assembler\CategoryAssembler;

final readonly class ListCategoryUseCase implements QueryUseCaseInterface
{
    public function __construct(
      public CategoryAssembler $assembler
    ) {
    }


    public function execute(): array
    {
        return $this->assembler->toListResponse();
    }
}
