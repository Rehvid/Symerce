<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Http;

use App\Common\Domain\Enums\CookieName;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\KernelInterface;

final readonly class CookieFactory
{
    public function __construct(private KernelInterface $kernel)
    {
    }

    public function create(CookieName $cookieName, string $value, \DateTimeInterface|int $expire): Cookie
    {
        return new Cookie(
            name:     $cookieName->value,
            value:    $value,
            expire:   $expire,
            secure:   'prod' === $this->kernel->getEnvironment(),
            httpOnly: true,
            raw:      true,
            sameSite: 'strict'
        );
    }
}
