<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\User\Domain\Enums\UserTokenType;
use App\User\Infrastructure\Repository\UserTokenRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserTokenRepository::class)]
class UserToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $token;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $expiresAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tokens')]
    private User $user;

    #[ORM\Column(type: 'string', length: 255)]
    private string $tokenType;

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function setExpiresAt(\DateTime $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function setTokenType(UserTokenType $tokenType): void
    {
        $this->tokenType = $tokenType->value;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getExpiresAt(): \DateTime
    {
        return $this->expiresAt;
    }

    public function getTokenType(): UserTokenType
    {
        return UserTokenType::from($this->tokenType);
    }
}
