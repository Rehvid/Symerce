<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Query;

use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\User\Application\Assembler\UserAssembler;
use App\User\Application\Query\GetUserCreationContextQuery;

final readonly class UserCreationContextQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserAssembler $assembler
    ) {
    }

    public function __invoke(GetUserCreationContextQuery $query): array
    {
        return $this->assembler->toFormContextResponse();
    }
}
