<?php

declare(strict_types=1);

namespace App\DTO\Request\User;

use App\Entity\User;
use App\Interfaces\PersistableInterface;
use App\Validator\ExistField as CustomAssertExistField;
use Symfony\Component\Validator\Constraints as Assert;

final class ForgotPasswordRequestDTO implements PersistableInterface
{
    #[Assert\NotBlank] #[Assert\Email] #[CustomAssertExistField(options: ['field' => 'email', 'className' => User::class])]
    public string $email;
}
