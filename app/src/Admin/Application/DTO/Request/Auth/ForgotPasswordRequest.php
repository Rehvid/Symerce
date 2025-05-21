<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\Auth;

use App\Admin\Domain\Entity\User;
use App\Validator\ExistsInDatabase as CustomAssertExistField;
use Symfony\Component\Validator\Constraints as Assert;

final class ForgotPasswordRequest
{
    #[Assert\NotBlank] #[Assert\Email] #[CustomAssertExistField(options: ['field' => 'email', 'className' => User::class])]
    public string $email;
}
