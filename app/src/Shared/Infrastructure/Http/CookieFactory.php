<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http;

use App\Shared\Domain\Enums\CookieName;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\KernelInterface;

final readonly class CookieFactory
{
    public function __construct(private KernelInterface $kernel) {}

    /**
     * @param int|\DateTimeInterface $expire
     */
    public function create(CookieName $cookieName, string $value, \DateTimeInterface|int $expire): Cookie
    {
        return new Cookie(
            name:     $cookieName->value,
            value:    $value,
            expire:   $expire,
            secure:   $this->kernel->getEnvironment() === 'prod',
            httpOnly: true,
            raw:      true,
            sameSite: 'strict'
        );
    }
}
