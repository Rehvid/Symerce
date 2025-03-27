<?php

declare(strict_types=1);

namespace App\Dto\Request\User;

use App\Interfaces\PersistableInterface;
use App\Validator\RepeatPassword as CustomAssertRepeatPassword;
use App\Validator\StrongPassword as CustomAssertStrongPassword;
use App\Validator\UniqueEmail as CustomAssertUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveUserDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Email] #[CustomAssertUniqueEmail]  public string $email,
        #[Assert\NotBlank] #[CustomAssertStrongPassword] public string $password,
        #[Assert\NotBlank] #[CustomAssertRepeatPassword] public string $passwordConfirmation,
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $firstname,
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $surname,
    ) {
    }
}
