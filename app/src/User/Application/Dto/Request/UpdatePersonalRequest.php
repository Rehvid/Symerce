<?php

declare(strict_types=1);

namespace App\User\Application\Dto\Request;

use App\Common\Application\Dto\FileData;
use App\Common\Application\Dto\Request\IdRequest;
use App\Common\Domain\Entity\User;
use App\Common\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

final class UpdatePersonalRequest
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

    public IdRequest $idRequest;

    public ?FileData $fileData;

    public function __construct(
        string $firstname,
        string $surname,
        string $email,
        string|int|null $id,
        ?array $avatar,
    ) {
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->email = $email;
        $this->idRequest = new IdRequest($id);
        $this->fileData = $avatar ? FileData::fromArray($avatar) : null;
    }
}
