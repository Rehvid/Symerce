<?php

declare(strict_types=1);

namespace App\Authentication\Application\Service;

use App\Common\Application\Dto\Response\ApiErrorResponse;
use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Dto\Response\MailResponse;
use App\Common\Domain\Entity\User;
use App\Common\Domain\Entity\UserToken;
use App\Common\Infrastructure\Mail\MailService;
use App\User\Domain\Enums\UserTokenType;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\Repository\UserTokenRepositoryInterface;
use Ramsey\Uuid\Guid\Guid;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class ForgetUserPasswordService
{
    public function __construct(
        private MailService  $mailService,
        private UserRepositoryInterface $userRepository,
        private UrlGeneratorInterface  $urlGenerator,
        private UserTokenRepositoryInterface $userTokenRepository,
    ) {
    }

    public function execute(string $email): ApiResponse
    {
        /** @var User|null $user */
        $user = $this->userRepository->loadUserByIdentifier($email);
        if (null === $user) {
            return new ApiResponse(
                error: new ApiErrorResponse(code: Response::HTTP_BAD_REQUEST, message: 'User Not found')
            );
        }

        $this->deleteOldUserTokens($user);

        $userToken = $this->createUserToken($user);

        $link = $this->generateLink($userToken->getToken());

        $this->send($email, $link);

        return new ApiResponse();
    }

    private function deleteOldUserTokens(User $user): void
    {
        $forgetPasswordTokens = $user->getTokens()->filter(
            /** @phpstan-ignore-next-line */
            fn (UserToken $userToken) => UserTokenType::FORGOT_PASSWORD === $userToken->getTokenType()
        );

        $this->userTokenRepository->remove($forgetPasswordTokens);
    }

    private function createUserToken(User $user): object
    {
        $userToken = new UserToken();
        $userToken->setUser($user);
        $userToken->setToken(Guid::uuid4()->toString());
        $userToken->setTokenType(UserTokenType::FORGOT_PASSWORD);
        $userToken->setExpiresAt((new \DateTime())->add(new \DateInterval('PT1H')));

        $this->userTokenRepository->save($userToken);

        return $userToken;
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
        $this->mailService->sendMail(new MailResponse(
            toEmail: $toEmail,
            subject: 'Przypomnienie hasła',
            template: 'reset-password.html.twig',
            context: [
                'link' => '<a class="link" href="'.$link.'">Link do zresetowania hasła</a>',
            ],
        ));
    }
}
