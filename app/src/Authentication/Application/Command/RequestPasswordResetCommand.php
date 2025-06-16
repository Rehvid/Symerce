<?php

declare(strict_types=1);

namespace App\Authentication\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;

final readonly class RequestPasswordResetCommand implements CommandInterface
{
    public function __construct(public string $email)
    {
    }
}
