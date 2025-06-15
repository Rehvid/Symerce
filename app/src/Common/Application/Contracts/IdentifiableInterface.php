<?php

declare(strict_types=1);

namespace App\Common\Application\Contracts;

interface IdentifiableInterface
{
    public function getId(): ?int;
}
