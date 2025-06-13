<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Request;

use App\Common\Infrastructure\Validator\RepeatPassword as CustomAssertRepeatPassword;
use App\Common\Infrastructure\Validator\StrongPassword as CustomAssertStrongPassword;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SavePasswordRequest
{
    #[Assert\When(
        expression: 'this.password !== null',
        constraints: [
            new CustomAssertStrongPassword(),
        ]
    )]
    public ?string $password;

    #[Assert\When(
        expression: 'this.passwordConfirmation !== null',
        constraints: [
            new CustomAssertRepeatPassword(),
        ]
    )]
    public ?string $passwordConfirmation;

    public function __construct(
        ?string $password,
        ?string $passwordConfirmation
    ) {
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
    }
}
