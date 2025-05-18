<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\User;

use App\Admin\Application\Assembler\UserAssembler;
use App\Shared\Application\UseCases\Base\QueryUseCaseInterface;

final readonly class GetUserCreateDataUseCase implements QueryUseCaseInterface
{
    public function __construct(
        private UserAssembler $userAssembler,
    ) {
    }

    public function execute(): array
    {
        return $this->userAssembler->toCreateFormDataResponse();
    }
}
