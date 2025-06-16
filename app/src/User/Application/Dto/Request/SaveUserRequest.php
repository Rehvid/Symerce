<?php

declare(strict_types=1);

namespace App\User\Application\Dto\Request;

use App\Common\Application\Dto\FileData;
use App\Common\Application\Dto\Request\IdRequest;
use App\Common\Application\Dto\Request\SavePasswordRequest;
use App\Common\Domain\Entity\User;
use App\Common\Infrastructure\Utils\BoolHelper;
use App\Common\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueEmail;
use App\User\Domain\Enums\UserRole;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveUserRequest
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
        string|int|null $id,
        ?string $password,
        ?string $passwordConfirmation,
        bool $isActive,
        ?array $avatar,
    ) {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->roles = $roles;
        $this->isActive = BoolHelper::castOrFail($isActive, 'isActive');
        $this->idRequest = new IdRequest($id);
        $this->passwordRequest = new SavePasswordRequest($password, $passwordConfirmation);
        $this->fileData = $avatar ? FileData::fromArray($avatar) : null;
    }
}
