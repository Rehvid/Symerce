<?php

declare(strict_types=1);

namespace App\Dto\Request;

use App\Validator\RepeatPassword as CustomAssertRepeatPassword;
use App\Validator\StrongPassword as CustomAssertStrongPassword;
use App\Validator\UniqueEmail as CustomAssertUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class RegistrationDto
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Email] #[CustomAssertUniqueEmail]  public string $email,
        #[Assert\NotBlank] #[CustomAssertStrongPassword] public string $password,
        #[Assert\NotBlank] #[CustomAssertRepeatPassword] public string $passwordConfirmation,
    ) {
    }
}
