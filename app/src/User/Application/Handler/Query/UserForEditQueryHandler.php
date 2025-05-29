<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Query;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\User\Application\Assembler\UserAssembler;
use App\User\Application\Query\GetUserForEditQuery;

final readonly class UserForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserAssembler $assembler
    ){}

    public function __invoke(GetUserForEditQuery $query): array
    {
        return $this->assembler->toFormDataResponse($query->user);
    }
}
