<?php

declare(strict_types=1);

namespace App\Shared\Application\UseCases\Base;

use App\Shared\Application\DTO\Request\RequestDtoInterface;


/**
 * @template TRequest of RequestDtoInterface
 * @template TResponse
 */
interface CreateUseCaseInterface
{
    /**
     * @param TRequest  $requestDto
     * @return TResponse
     */
    public function execute(RequestDtoInterface $requestDto): mixed;
}
