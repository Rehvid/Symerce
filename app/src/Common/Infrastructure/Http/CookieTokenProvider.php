<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Http;

use App\Common\Application\Contracts\TokenProviderInterface;
use App\Common\Domain\Enums\CookieName;
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
