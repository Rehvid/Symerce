<?php

declare(strict_types=1);

namespace App\DTO\Admin\Request\User;

use App\DTO\Admin\Request\PersistableInterface;
use App\Entity\User;
use App\Validator\ExistsInDatabase as CustomAssertExistField;
use Symfony\Component\Validator\Constraints as Assert;

final class ForgotPasswordRequestDTO implements PersistableInterface
{
    #[Assert\NotBlank] #[Assert\Email] #[CustomAssertExistField(options: ['field' => 'email', 'className' => User::class])]
    public string $email;
}
