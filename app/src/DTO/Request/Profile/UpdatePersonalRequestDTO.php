<?php

declare(strict_types=1);

namespace App\DTO\Request\Profile;

use App\Interfaces\PersistableInterface;
use App\Validator\UniqueEmail as CustomAssertUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdatePersonalRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $firstname,
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $surname,
        #[Assert\NotBlank] #[Assert\Email] #[CustomAssertUniqueEmail] public string $email,
        #[Assert\NotBlank] public int $id
    ) {
    }
}
