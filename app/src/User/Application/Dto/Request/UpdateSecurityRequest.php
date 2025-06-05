<?php

declare(strict_types=1);

namespace App\User\Application\Dto\Request;

use App\Common\Infrastructure\Validator\RepeatPassword as CustomAssertRepeatPassword;
use App\Common\Infrastructure\Validator\StrongPassword as CustomAssertStrongPassword;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdateSecurityRequest
{
    public function __construct(
        #[Assert\NotBlank] #[CustomAssertStrongPassword] public string $password,
        #[Assert\NotBlank] #[CustomAssertRepeatPassword] public string $passwordConfirmation,
    ) {
    }
}
