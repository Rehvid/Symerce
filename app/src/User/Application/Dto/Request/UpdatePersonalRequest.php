<?php

declare(strict_types=1);

namespace App\User\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\FileData;
use App\Common\Domain\Entity\User;
use App\Common\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

final class UpdatePersonalRequest implements ArrayHydratableInterface
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $firstname;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $surname;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[CustomAssertUniqueEmail(options: ['field' => 'email', 'className' => User::class])]
    public string $email;

    #[Assert\NotBlank]
    public int $id;

    public ?FileData $fileData;

    public function __construct(
        string $firstname,
        string $surname,
        string $email,
        int $id,
        ?FileData $fileData = null,
    ) {
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->email = $email;
        $this->id = $id;
        $this->fileData = $fileData;
    }

    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $avatar = $data['avatar'] ?? null;
        $fileData = null;
        if (!empty($avatar)) {
            $fileData = FileData::fromArray($avatar[0]);
        }

        return new self(
            firstname: $data['firstname'],
            surname: $data['surname'],
            email: $data['email'],
            id: $data['id'],
            fileData: $fileData,
        );
    }
}
