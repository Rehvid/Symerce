<?php

declare(strict_types=1);

namespace App\Authentication\Application\Command;

use App\Shared\Application\Command\CommandInterface;

final readonly class RequestPasswordResetCommand implements CommandInterface
{
    public function __construct(public string $email) {}
}
