<?php

declare(strict_types=1);

namespace App\User\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\FileData;
use App\Common\Application\Dto\Request\IdRequest;
use App\Common\Application\Dto\Request\SavePasswordRequest;
use App\Common\Domain\Entity\User;
use App\Common\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueEmail;
use App\User\Domain\Enums\UserRole;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveUserRequest implements ArrayHydratableInterface
{
    #[Assert\NotBlank]
    #[Assert\Email]
    #[CustomAssertUniqueEmail(options: ['field' => 'email', 'className' => User::class])]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $firstname;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $surname;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [UserRole::class, 'values'], multiple: true)]
    public array $roles;


    #[Assert\Valid]
    public IdRequest $idRequest;

    #[Assert\Valid]
    public SavePasswordRequest $passwordRequest;


    public bool $isActive;


    #[Assert\Valid]
    public ?FileData $fileData;


    public function __construct(
        string $email,
        string $firstname,
        string $surname,
        array $roles,
        IdRequest $idRequest,
        SavePasswordRequest $savePasswordRequest,
        bool $isActive,
        ?FileData $fileData
    ) {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->roles = $roles;
        $this->isActive = $isActive;
        $this->idRequest = $idRequest;
        $this->passwordRequest = $savePasswordRequest;
        $this->fileData = $fileData;
    }


    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $avatar = $data['avatar'] ?? null;

        return new self(
            email: $data['email'],
            firstname: $data['firstname'],
            surname: $data['surname'],
            roles: $data['roles'],
            idRequest: new IdRequest($data['id'] ?? null),
            savePasswordRequest: new SavePasswordRequest(
                password: $data['password'] ?? null,
                passwordConfirmation: $data['passwordConfirmation'] ?? null,
            ),
            isActive: $data['isActive'],
            fileData: $avatar ? FileData::fromArray($avatar) : null,
        );
    }
}
