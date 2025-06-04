<?php

declare(strict_types=1);

namespace App\User\Application\Dto\Request;

use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Infrastructure\Validator\RepeatPassword as CustomAssertRepeatPassword;
use App\Shared\Infrastructure\Validator\StrongPassword as CustomAssertStrongPassword;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdateSecurityRequest implements RequestDtoInterface
{
    public function __construct(
        #[Assert\NotBlank] #[CustomAssertStrongPassword] public string $password,
        #[Assert\NotBlank] #[CustomAssertRepeatPassword] public string $passwordConfirmation,
    ) {
    }
}
