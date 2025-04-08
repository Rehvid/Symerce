<?php

declare(strict_types=1);

namespace App\DTO\Request\UserToken;

use App\Entity\User;
use App\Enums\TokenType;
use App\Interfaces\PersistableInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class StoreUserTokenRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] public User $user,
        #[Assert\NotBlank] #[Assert\Length(min: 16)] public string $token,
        #[Assert\NotBlank] public TokenType $tokenType,
        #[Assert\NotBlank] public \DateTime $expiresAt
    ) {

    }
}
