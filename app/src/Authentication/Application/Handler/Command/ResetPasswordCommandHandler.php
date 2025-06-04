<?php

declare(strict_types=1);

namespace App\Authentication\Application\Handler\Command;

use App\Authentication\Application\Command\ResetPasswordCommand;
use App\Authentication\Application\Service\ResetUserPasswordService;
use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\ApiResponse;

final readonly class ResetPasswordCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ResetUserPasswordService $resetPasswordService
    ) {}

    public function __invoke(ResetPasswordCommand $command): ApiResponse
    {
        return $this->resetPasswordService->execute($command->newPassword, $command->token);
    }
}
