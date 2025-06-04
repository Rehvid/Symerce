<?php

declare(strict_types=1);

namespace App\Authentication\Application\Handler\Command;

use App\Authentication\Application\Command\RequestPasswordResetCommand;
use App\Authentication\Application\Service\ForgetUserPasswordService;
use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\ApiResponse;

final readonly class RequestPasswordResetCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ForgetUserPasswordService $forgetPasswordService,
    ) {
    }

    public function __invoke(RequestPasswordResetCommand $command): ApiResponse
    {
        return $this->forgetPasswordService->execute($command->email);
    }
}
