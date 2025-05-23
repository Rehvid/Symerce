<?php

declare(strict_types=1);

namespace App\DTO\Admin\Request\UserToken;

use App\DTO\Admin\Request\PersistableInterface;
use App\Entity\User;
use App\Enums\TokenType;
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
