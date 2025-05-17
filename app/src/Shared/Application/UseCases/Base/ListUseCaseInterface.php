<?php

declare(strict_types=1);

namespace App\Shared\Application\UseCases\Base;

use Symfony\Component\HttpFoundation\Request;

interface ListUseCaseInterface
{
    public function execute(Request $request): mixed;
}
