<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Command;

use App\Shared\Application\Command\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class CommandBus implements CommandBusInterface
{

    public function __construct(
        private MessageBusInterface $messageBus
    ) {
    }

    public function dispatch(CommandInterface $command): void
    {
        $this->messageBus->dispatch($command);
    }
}
