<?php

declare(strict_types=1);

namespace App\DTO\Admin\Request\Profile;

use App\DTO\Admin\Request\PersistableInterface;
use App\Entity\User;
use App\Traits\FileRequestMapperTrait;
use App\Validator\UniqueEntityField as CustomAssertUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

final class UpdatePersonalRequestDTO implements PersistableInterface
{
    use FileRequestMapperTrait;

    /**
     * @param array<string, mixed> $avatar
     *
     * @throws \ReflectionException
     */
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public readonly string $firstname,
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public readonly string $surname,
        #[Assert\NotBlank]
        #[Assert\Email]
        #[CustomAssertUniqueEmail(options: ['field' => 'email', 'className' => User::class])]
        public readonly string $email,
        #[Assert\NotBlank] public readonly int $id,
        public array $avatar = [],
    ) {
        $this->avatar = $this->createFileRequestDTOs($this->avatar);
    }
}
