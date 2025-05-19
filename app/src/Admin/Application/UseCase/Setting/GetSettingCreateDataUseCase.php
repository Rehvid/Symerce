<?php

declare (strict_types=1);

namespace App\Admin\Application\UseCase\Setting;

use App\Admin\Application\Assembler\SettingAssembler;
use App\Shared\Application\UseCases\Base\QueryUseCaseInterface;

final readonly class GetSettingCreateDataUseCase implements QueryUseCaseInterface
{
    public function __construct(
        private SettingAssembler $assembler,
    ) {
    }

    public function execute(): array
    {
        return $this->assembler->toCreateFormDataResponse();
    }
}
