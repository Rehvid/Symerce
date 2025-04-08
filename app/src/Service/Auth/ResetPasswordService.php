<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\DTO\Request\Profile\UpdateSecurityRequestDTO;
use App\Entity\User;
use App\Entity\UserToken;
use App\Service\DataPersister\Manager\PersisterManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class ResetPasswordService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PersisterManager $persisterManager,
    ) {
    }

    public function handleResetPassword(UpdateSecurityRequestDTO $changePasswordRequestDTO, string $token): void
    {
        $userToken = $this->entityManager->getRepository(UserToken::class)->findOneBy(['token' => $token]);
        if (null === $userToken) {
            throw new NotFoundHttpException('Token not found', code: Response::HTTP_NOT_FOUND);
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $userToken->getUser()->getId()]);
        if (null === $user) {
            throw new NotFoundHttpException('User not found', code: Response::HTTP_NOT_FOUND);
        }


        $this->persisterManager->update($changePasswordRequestDTO, $user);
        $this->persisterManager->delete($userToken);
    }
}
