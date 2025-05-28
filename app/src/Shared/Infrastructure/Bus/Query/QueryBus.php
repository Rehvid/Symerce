<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Query;

use App\Shared\Application\Query\QueryInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class QueryBus implements QueryBusInterface
{
    public function __construct(
        private  MessageBusInterface $messageBus
    ) {}


    public function ask(QueryInterface $query): void
    {
        $this->messageBus->dispatch($query);
    }
}
