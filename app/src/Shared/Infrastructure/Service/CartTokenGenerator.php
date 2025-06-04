<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service;

use App\Cart\Domain\Repository\CartRepositoryInterface;
use App\Common\Domain\Entity\Cart;
use Ramsey\Uuid\Guid\Guid;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class CartTokenGenerator
{
    private const string DELIMITER = '_';

    public function __construct(
        private RequestStack   $requestStack,
        private CartRepositoryInterface $cartRepository
    ) {
    }

    public function generate(): string
    {
        $session = $this->requestStack->getSession()->getId();

        $token = $session . self::DELIMITER . Guid::uuid4()->toString();

        $exists = $this->checkTokenExistence($token);
        if (null === $exists) {
            return $token;
        }

        return $this->generateUniqueToken($token);
    }

    private function checkTokenExistence(string $token): ?Cart
    {
        return $this->cartRepository->findByToken($token);
    }

    private function generateUniqueToken(string $token): string
    {
        $timestamp = microtime(true);
        $encodedTimestamp = base64_encode((string) $timestamp);
        $randomString = bin2hex(random_bytes(64));

        return $token . self::DELIMITER . $encodedTimestamp . self::DELIMITER . $randomString;
    }
}
