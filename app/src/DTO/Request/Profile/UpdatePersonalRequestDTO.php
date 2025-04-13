<?php

declare(strict_types=1);

namespace App\DTO\Request\Profile;

use App\DTO\Request\FileRequestDTO;
use App\Enums\FileMimeType;
use App\Factory\PersistableDTOFactory;
use App\Interfaces\PersistableInterface;
use App\Validator\UniqueEmail as CustomAssertUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

final class UpdatePersonalRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public readonly string $firstname,
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public readonly string $surname,
        #[Assert\NotBlank] #[Assert\Email] #[CustomAssertUniqueEmail] public readonly string $email,
        #[Assert\NotBlank] public readonly int $id,
        public array $avatar = [],
    ) {
        $this->transformToImageRequestDTO($this->avatar);
    }

    /**
     * @param array<int, mixed> $image
     *
     * @throws \ReflectionException
     */
    private function transformToImageRequestDTO(array $avatar): void
    {
        $result = [];
        foreach ($avatar as $imageFile) {
            $fileRequestDTO = PersistableDTOFactory::create(FileRequestDTO::class, [
                'size' => $imageFile['size'] ?? null,
                'name' => $imageFile['name'] ?? null,
                'type' => FileMimeType::tryFrom($imageFile['type'] ?? null),
                'content' => $imageFile['content'] ?? null,
            ]);
            $result[] = $fileRequestDTO;
        }

        $this->avatar = $result;
    }
}
