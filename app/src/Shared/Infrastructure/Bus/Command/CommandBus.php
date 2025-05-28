<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Command;

use App\Shared\Application\Command\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

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

    public function handle(CommandInterface $command): mixed
    {
        $envelope = $this->messageBus->dispatch($command);
        $stamp = $envelope->last(HandledStamp::class);

        if (!$stamp) {
            throw new \RuntimeException('Not found handler for command');
        }

        return $stamp->getResult();
    }
}
