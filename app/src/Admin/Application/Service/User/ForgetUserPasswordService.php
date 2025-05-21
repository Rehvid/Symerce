<?php

declare(strict_types=1);

namespace App\Admin\Application\Service\User;

use App\Admin\Application\DTO\Request\Auth\ForgotPasswordRequest;
use App\Admin\Domain\Enums\TokenType;
use App\Admin\Domain\Repository\UserRepositoryInterface;
use App\Admin\Domain\Repository\UserTokenRepositoryInterface;
use App\Entity\User;
use App\Entity\UserToken;
use App\Shared\Application\DTO\Response\ApiErrorResponse;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\DTO\Response\MailResponse;
use App\Shared\Infrastructure\Mail\MailService;
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

    public function execute(ForgotPasswordRequest $request): ApiResponse
    {
        /** @var User|null $user */
        $user = $this->userRepository->loadUserByIdentifier($request->email);
        if (null === $user) {
            return new ApiResponse(
                error: new ApiErrorResponse(code: Response::HTTP_BAD_REQUEST, message: 'User Not found')
            );
        }

        $this->deleteOldUserTokens($user);

        $userToken = $this->createUserToken($user);

        $link = $this->generateLink($userToken->getToken());

        $this->send($request->email, $link);

        return new ApiResponse();
    }

    private function deleteOldUserTokens(User $user): void
    {
        $forgetPasswordTokens = $user->getTokens()->filter(
            /** @phpstan-ignore-next-line */
            fn (UserToken $userToken) => TokenType::FORGOT_PASSWORD === $userToken->getTokenType()
        );

        $this->userTokenRepository->remove($forgetPasswordTokens);
    }

    private function createUserToken(User $user): object
    {
        $userToken = new UserToken();
        $userToken->setUser($user);
        $userToken->setToken(Guid::uuid4()->toString());
        $userToken->setTokenType(TokenType::FORGOT_PASSWORD);
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
