<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\Profile;

use App\Admin\Domain\Model\FileData;
use App\Common\Domain\Entity\User;
use App\Shared\Application\Contract\ArrayHydratableInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

final class UpdatePersonalRequest implements RequestDtoInterface, ArrayHydratableInterface
{


    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public readonly string $firstname,
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public readonly string $surname,
        #[Assert\NotBlank]
        #[Assert\Email]
        #[CustomAssertUniqueEmail(options: ['field' => 'email', 'className' => User::class])]
        public readonly string $email,
        #[Assert\NotBlank] public readonly int $id,
        public ?FileData $fileData = null,
    ) {
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
