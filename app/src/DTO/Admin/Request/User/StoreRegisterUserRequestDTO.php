<?php

declare(strict_types=1);

namespace App\DTO\Admin\Request\User;

use App\DTO\Admin\Request\PersistableInterface;
use App\Entity\User;
use App\Validator\RepeatPassword as CustomAssertRepeatPassword;
use App\Validator\StrongPassword as CustomAssertStrongPassword;
use App\Validator\UniqueEntityField as CustomAssertUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class StoreRegisterUserRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        #[CustomAssertUniqueEmail(options: ['field' => 'email', 'className' => User::class])]
        public string $email,
        #[Assert\NotBlank] #[CustomAssertStrongPassword] public string $password,
        #[Assert\NotBlank] #[CustomAssertRepeatPassword] public string $passwordConfirmation,
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $firstname,
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $surname,
    ) {
    }
}
