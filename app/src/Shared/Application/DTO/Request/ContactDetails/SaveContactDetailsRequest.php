<?php

declare(strict_types=1);

namespace App\Shared\Application\DTO\Request\ContactDetails;

use App\Common\Domain\Entity\User;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveContactDetailsRequest implements RequestDtoInterface
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2)]
    public string $firstname;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2)]
    public string $surname;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[CustomAssertUniqueEmail(options: ['field' => 'email', 'className' => User::class])]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 5)]
    public string $phone;

    public function __construct(
        string $firstname,
        string $surname,
        string $email,
        string $phone,
    ) {
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->email = $email;
        $this->phone = $phone;
    }
}
