<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Request\ContactDetails;

use App\Common\Domain\Entity\User;
use App\Common\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveContactDetailsRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $firstname;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $surname;

    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: "/^\+?[0-9]{7,15}$/",
        message: "The phone number may optionally start with '+' and must contain between 7 and 15 digits."
    )]
    public string $phone;

    public function __construct(
        string $firstname,
        string $surname,
        string $phone,
    ) {
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->phone = $phone;
    }
}
