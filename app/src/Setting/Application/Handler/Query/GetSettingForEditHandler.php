<?php

declare (strict_types = 1);

namespace App\Setting\Application\Handler\Query;

use App\Setting\Application\Assembler\SettingAssembler;
use App\Setting\Application\Query\GetSettingForEditQuery;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class GetSettingForEditHandler implements QueryHandlerInterface
{
    public function __construct(
        private SettingAssembler $assembler,
    ) {}

    public function __invoke(GetSettingForEditQuery $query): array
    {
        return $this->assembler->toFormDataResponse($query->setting);
    }
}
