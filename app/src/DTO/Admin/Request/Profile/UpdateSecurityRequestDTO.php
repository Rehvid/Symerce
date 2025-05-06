<?php

declare(strict_types=1);

namespace App\DTO\Admin\Request\Profile;

use App\DTO\Admin\Request\PersistableInterface;
use App\Validator\RepeatPassword as CustomAssertRepeatPassword;
use App\Validator\StrongPassword as CustomAssertStrongPassword;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdateSecurityRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] #[CustomAssertStrongPassword] public string $password,
        #[Assert\NotBlank] #[CustomAssertRepeatPassword] public string $passwordConfirmation,
    ) {
    }
}
