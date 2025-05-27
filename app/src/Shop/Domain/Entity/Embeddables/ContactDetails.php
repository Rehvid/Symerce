<?php

declare(strict_types=1);

namespace App\Shop\Domain\Entity\Embeddables;


use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class ContactDetails
{
    #[ORM\Column(type: "string", length: 255)]
    private string $firstname;

    #[ORM\Column(type: "string", length: 255)]
    private string $surname;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    private string $email;

    #[ORM\Column(type: "string", length: 25)]
    private string $phone;

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getFullName(): string
    {
        return $this->firstname . ' '  . $this->surname;
    }
}
