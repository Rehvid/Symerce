<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;

    public function handle(CommandInterface $command): mixed;
}
