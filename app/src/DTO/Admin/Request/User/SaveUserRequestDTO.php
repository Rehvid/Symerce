<?php

declare(strict_types=1);

namespace App\DTO\Admin\Request\User;

use App\DTO\Admin\Request\PersistableInterface;
use App\Entity\User;
use App\Enums\Roles;
use App\Traits\FileRequestMapperTrait;
use App\Validator\RepeatPassword as CustomAssertRepeatPassword;
use App\Validator\StrongPassword as CustomAssertStrongPassword;
use App\Validator\UniqueEntityField as CustomAssertUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class SaveUserRequestDTO implements PersistableInterface
{
    use FileRequestMapperTrait;

    /**
     * @param array<string, mixed> $avatar
     * @param array<int|string>    $roles
     *
     * @throws \ReflectionException
     */
    public function __construct(
        #[Assert\NotBlank] #[Assert\Email]
        #[CustomAssertUniqueEmail(options: ['field' => 'email', 'className' => User::class])]
        public readonly string $email,
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public readonly string $firstname,
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public readonly string $surname,
        #[Assert\NotBlank] #[Assert\Choice(callback: [Roles::class, 'values'], multiple: true)] public array $roles,
        public readonly ?int $id,
        public readonly ?string $password,
        public readonly ?string $passwordConfirmation,
        public readonly bool $isActive,
        public array $avatar = [],
    ) {
        $this->avatar = $this->createFileRequestDTOs($avatar);
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
}
