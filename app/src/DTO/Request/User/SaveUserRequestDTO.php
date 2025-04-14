<?php

declare(strict_types=1);

namespace App\DTO\Request\User;

use App\Interfaces\PersistableInterface;
use App\Traits\FileTransformerTrait;
use App\Validator\RepeatPassword as CustomAssertRepeatPassword;
use App\Validator\StrongPassword as CustomAssertStrongPassword;
use App\Validator\UniqueEmail as CustomAssertUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class SaveUserRequestDTO implements PersistableInterface
{
    use FileTransformerTrait;

    public function __construct(
        #[Assert\NotBlank] #[Assert\Email] #[CustomAssertUniqueEmail] public readonly string $email,
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public readonly string $firstname,
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public readonly string $surname,
        #[Assert\NotBlank] public array $roles,
        public readonly ?int $id,
        public readonly ?string $password,
        public readonly ?string $passwordConfirmation,
        public readonly bool $isActive,
        public array $avatar = [],
    ) {
        $this->avatar = $this->transformToFileRequestDTO($avatar);
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
                $context->buildViolation($violation->getMessage())
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
                $context->buildViolation($violation->getMessage())
                    ->atPath('passwordConfirmation')
                    ->addViolation();
            }
        }
    }
}
