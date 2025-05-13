<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;

final readonly class CookieManager
{
    public function __construct(
        private KernelInterface $kernel,
        private RequestStack $requestStack
    ) {}

    public function create(string $name, string $value, \DateTimeInterface|int $expire): Cookie
    {
        return new Cookie(
            name: $name,
            value: $value,
            expire: $expire,
            secure: 'prod' === $this->kernel->getEnvironment(),
            httpOnly: true,
            raw: true,
            sameSite: 'strict'
        );
    }

    public function exists(string $name): bool
    {
        return $this->requestStack->getCurrentRequest()->cookies->has($name);
    }

    public function get(string $name): mixed
    {
        if (!$this->exists($name)) {
            return null;
        }

        return $this->requestStack->getCurrentRequest()->cookies->get($name);
    }
}
