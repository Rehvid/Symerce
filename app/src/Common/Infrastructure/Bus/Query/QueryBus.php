<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final readonly class QueryBus implements QueryBusInterface
{
    public function __construct(
        private MessageBusInterface $messageBus
    ) {
    }

    public function ask(QueryInterface $query): mixed
    {
        $envelope = $this->messageBus->dispatch($query);
        $stamp = $envelope->last(HandledStamp::class);

        if (!$stamp) {
            throw new \RuntimeException('Not found handler for query');
        }

        return $stamp->getResult();
    }
}
