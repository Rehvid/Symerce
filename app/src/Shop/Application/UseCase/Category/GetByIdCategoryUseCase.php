<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Category;

use App\Entity\Category;
use App\Shop\Application\Assembler\CategoryAssembler;

final readonly class GetByIdCategoryUseCase
{
    public function __construct(
       private CategoryAssembler $assembler
    ) {}

    public function execute(Category $category): array
    {
        return $this->assembler->toShowResponse($category);
    }
}
