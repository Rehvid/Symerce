<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Admin\Application\DTO\Request\Profile\UpdateSecurityRequest;
use App\Admin\Domain\Repository\UserRepositoryInterface;
use App\Admin\Domain\Repository\UserTokenRepositoryInterface;
use App\Entity\User;
use App\Entity\UserToken;
use App\Service\DataPersister\Manager\PersisterManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class ResetPasswordService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PersisterManager $persisterManager,
        private UserPasswordHasherInterface $passwordHasher,
        private UserRepositoryInterface $userRepository,
        private UserTokenRepositoryInterface $userTokenRepository,
    ) {
    }

    public function handleResetPassword(UpdateSecurityRequest $changePasswordRequestDTO, string $token): void
    {
        $userToken = $this->entityManager->getRepository(UserToken::class)->findOneBy(['token' => $token]);
        if (null === $userToken) {
            throw new NotFoundHttpException('Token not found', code: Response::HTTP_NOT_FOUND);
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $userToken->getUser()->getId()]);
        if (null === $user) {
            throw new NotFoundHttpException('User not found', code: Response::HTTP_NOT_FOUND);
        }

        $user->setPassword($this->passwordHasher->hashPassword($user, $changePasswordRequestDTO->password));

        $this->userRepository->save($user);
        $this->userTokenRepository->remove($userToken);
    }
}
