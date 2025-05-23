<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\User;

use App\Admin\Domain\Model\FileData;
use App\Entity\User;
use App\Enums\AdminRole;
use App\Shared\Application\Contract\ArrayHydratableInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Validator\UniqueEntityField as CustomAssertUniqueEmail;
use App\Validator\RepeatPassword as CustomAssertRepeatPassword;
use App\Validator\StrongPassword as CustomAssertStrongPassword;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final readonly class SaveUseRequest implements RequestDtoInterface, ArrayHydratableInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Email]
        #[CustomAssertUniqueEmail(options: ['field' => 'email', 'className' => User::class])]
        public string                                                                                            $email,
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string                                                $firstname,
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string                                                $surname,
        #[Assert\NotBlank] #[Assert\Choice(callback: [AdminRole::class, 'values'], multiple: true)] public array $roles,
        public ?int                                                                                              $id,
        public ?string                                                                                           $password,
        public ?string                                                                                           $passwordConfirmation,
        public bool                                                                                              $isActive,
        public ?FileData                                                                                         $avatar = null,
    ) {
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
            avatar: $fileData,
        );
    }
}
