<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Repository\CartRepository;
use Ramsey\Uuid\Guid\Guid;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class CartTokenGenerator
{
    private const string DELIMITER = '_';


    public function __construct(
        private RequestStack   $requestStack,
        private CartRepository $cartRepository
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
        return $this->cartRepository->findOneBy(['cartToken' => $token]);
    }

    private function generateUniqueToken(string $token): string
    {
        $timestamp = microtime(true);
        $encodedTimestamp = base64_encode((string) $timestamp);
        $randomString = bin2hex(random_bytes(64));

        return $token . self::DELIMITER . $encodedTimestamp . self::DELIMITER . $randomString;
    }
}
