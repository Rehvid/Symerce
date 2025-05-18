<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Category;

use App\Admin\Application\Assembler\CategoryAssembler;
use App\Shared\Application\UseCases\Base\QueryUseCaseInterface;

final readonly class GetCategoryCreateDataUseCase implements QueryUseCaseInterface
{
    public function __construct(
        private CategoryAssembler $categoryAssembler,
    ) {
    }

    public function execute(): array
    {
        return $this->categoryAssembler->toCreateFormDataResponse();
    }
}
