<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Security;

use App\Common\Application\Contracts\TokenParserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\InvalidTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

final readonly class LexikTokenParser implements TokenParserInterface
{
    public function __construct(
        private JWTTokenManagerInterface $manager
    ) {

    }

    public function parse(string $token): array
    {
        try {
            $decodedToken = $this->manager->parse($token);

            if (isset($decodedToken['exp'])) {
                $expirationTime = $decodedToken['exp'];

                $currentTime = time();
                if ($expirationTime < $currentTime) {
                    throw new InvalidTokenException('Token expired');
                }
            }

            return $decodedToken;
        } catch (\Exception $e) {
            throw new InvalidTokenException('Could not parse token: '.$e->getMessage());
        }
    }
}
