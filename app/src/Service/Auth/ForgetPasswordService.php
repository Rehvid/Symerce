<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Admin\Infrastructure\Repository\UserDoctrineRepository;
use App\DTO\Admin\Request\User\ForgotPasswordRequestDTO;
use App\DTO\Admin\Request\UserToken\StoreUserTokenRequestDTO;
use App\DTO\Admin\Response\Mail\MailResponseDTO;
use App\Entity\User;
use App\Entity\UserToken;
use App\Enums\TokenType;
use App\Exceptions\PersisterException;
use App\Factory\PersistableDTOFactory;
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\MailService;
use Ramsey\Uuid\Guid\Guid;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class ForgetPasswordService
{
    public function __construct(
        private MailService            $mailService,
        private UserDoctrineRepository $userRepository,
        private PersisterManager       $persisterManager,
        private UrlGeneratorInterface  $urlGenerator,
    ) {

    }

    /**
     * @throws PersisterException|\ReflectionException
     */
    public function sendMail(ForgotPasswordRequestDTO $dto): void
    {
        /** @var User|null $user */
        $user = $this->userRepository->loadUserByIdentifier($dto->email);
        if (null === $user) {
            throw new NotFoundHttpException('User not found');
        }

        $this->deleteOldUserTokens($user);

        /** @var UserToken $userToken */
        $userToken = $this->createUserToken($user);

        $link = $this->generateLink($userToken->getToken());

        $this->send($dto->email, $link);
    }

    private function deleteOldUserTokens(User $user): void
    {

        $forgetPasswordTokens = $user->getTokens()->filter(
            /** @phpstan-ignore-next-line */
            fn (UserToken $userToken) => TokenType::FORGOT_PASSWORD === $userToken->getTokenType()
        );

        $this->persisterManager->deleteCollection($forgetPasswordTokens);
    }

    /**
     * @throws PersisterException
     * @throws \ReflectionException
     */
    private function createUserToken(User $user): object
    {
        $persist = PersistableDTOFactory::create(StoreUserTokenRequestDTO::class, [
            'user' => $user,
            'token' => Guid::uuid4()->toString(),
            'tokenType' => TokenType::FORGOT_PASSWORD,
            'expiresAt' => (new \DateTime())->add(new \DateInterval('PT1H')),
        ]);

        return $this->persisterManager->persist($persist);
    }

    private function generateLink(string $token): string
    {
        return $this->urlGenerator->generate(
            'app_admin_react',
            [
                'reactRoute' => 'public/reset-password',
                'token' => $token,
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

    private function send(string $toEmail, string $link): void
    {
        $this->mailService->sendMail(MailResponseDTO::fromArray([
            'toEmail' => $toEmail,
            'subject' => 'Przypomnienie hasła',
            'context' => [
                'link' => '<a class="link" href="'.$link.'">Link do zresetowania hasła</a>',
            ],
            'template' => 'reset-password.html.twig',
        ]));
    }
}
