<?php

declare(strict_types=1);

namespace App\Authentication\Application\Handler\Command;

use App\Authentication\Application\Command\VerifyUserAuthorizationCommand;
use App\Authentication\Application\Dto\AuthorizationResult;
use App\Authentication\Application\Service\AuthorizeUserService;
use App\Common\Application\Command\Interfaces\CommandHandlerInterface;

final readonly class VerifyUserAuthorizationCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AuthorizeUserService $authService,
    ) {
    }

    public function __invoke(VerifyUserAuthorizationCommand $command): AuthorizationResult
    {
        return $this->authService->verifyUserAuthorization();
    }
}
