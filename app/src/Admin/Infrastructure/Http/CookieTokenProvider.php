<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Http;

use App\Admin\Application\Contract\TokenProviderInterface;
use App\Shared\Domain\Enums\CookieName;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\InvalidTokenException;
use Symfony\Component\HttpFoundation\RequestStack;


final readonly class CookieTokenProvider implements TokenProviderInterface
{
    public function __construct(private RequestStack $requestStack) {}

    public function getToken(): string
    {
        $token = $this->requestStack->getMainRequest()?->cookies->get(CookieName::ADMIN_BEARER->value);
        if (!$token) {
            throw new InvalidTokenException('Token not found');
        }
        return $token;
    }
}
