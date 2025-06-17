<?php

declare(strict_types=1);

namespace App\Authentication\Application\Dto\Request;

use App\Common\Domain\Entity\User;
use App\Common\Infrastructure\Validator\ExistsInDatabase as CustomAssertExistField;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class ResetPasswordRequest
{
    #[Assert\NotBlank]
    #[Assert\Email]
    #[CustomAssertExistField(options: [
        'field' => 'email',
        'className' => User::class,
        'message' => 'base.validation.forgot_password_email_no_found',
    ])]
    public string $email;

    public function __construct(
        string $email
    ) {
        $this->email = $email;
    }
}
