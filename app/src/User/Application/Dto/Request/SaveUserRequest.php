<?php

declare(strict_types=1);

namespace App\User\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\FileData;
use App\Common\Domain\Entity\User;
use App\Common\Infrastructure\Validator\RepeatPassword as CustomAssertRepeatPassword;
use App\Common\Infrastructure\Validator\StrongPassword as CustomAssertStrongPassword;
use App\Common\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueEmail;
use App\User\Domain\Enums\UserRole;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final readonly class SaveUserRequest implements ArrayHydratableInterface
{
    #[Assert\NotBlank]
    #[Assert\Email]
    #[CustomAssertUniqueEmail(options: ['field' => 'email', 'className' => User::class])]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2)]
    public string $firstname;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2)]
    public string $surname;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [UserRole::class, 'values'], multiple: true)]
    public array $roles;

    public ?string $phone;

    public ?int $id;

    public ?string $password;

    public ?string $passwordConfirmation;


    public bool $isActive;

    public ?FileData $fileData;


    public function __construct(
        string $email,
        string $firstname,
        string $surname,
        array $roles,
        ?int $id,
        ?string $password,
        ?string $passwordConfirmation,
        bool $isActive,
        ?FileData $fileData
    ) {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->roles = $roles;
        $this->id = $id;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
        $this->isActive = $isActive;
        $this->fileData = $fileData;
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context): void
    {
        $validator = $context->getValidator();
        if (!empty($this->password) || null === $this->id) {
            $violations = $validator->validate($this->password, [
                new Assert\NotBlank(),
                new CustomAssertStrongPassword(),
            ]);

            foreach ($violations as $violation) {
                $context->buildViolation((string) $violation->getMessage())
                    ->atPath('password')
                    ->addViolation();
            }
        }

        if (!empty($this->passwordConfirmation) || null === $this->id) {
            $violations = $validator->validate($this->passwordConfirmation, [
                new Assert\NotBlank(),
                new CustomAssertRepeatPassword(),
            ]);

            foreach ($violations as $violation) {
                $context->buildViolation((string) $violation->getMessage())
                    ->atPath('passwordConfirmation')
                    ->addViolation();
            }
        }
    }

    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $avatar = $data['avatar'] ?? null;
        $fileData = null;
        if (!empty($avatar)) {
            $fileData = FileData::fromArray($avatar[0]);
        }

        return new self(
            email: $data['email'],
            firstname: $data['firstname'],
            surname: $data['surname'],
            roles: $data['roles'],
            id: $data['id'] ?? null,
            password: $data['password'] ?? null,
            passwordConfirmation: $data['passwordConfirmation'] ?? null,
            isActive: $data['isActive'],
            fileData: $fileData,
        );
    }
}
