<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Mail;

use App\Common\Application\Dto\Response\MailResponse;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

readonly final class MailService
{
    public function __construct(
        private MailerInterface $mailer
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendMail(MailResponse $mailResponse): void
    {
        $email = (new TemplatedEmail())
            ->from('admin@symerce.com')
            ->to($mailResponse->toEmail)
            ->subject($mailResponse->subject)
            ->htmlTemplate('emails/'.$mailResponse->template)
            ->locale('pl')
            ->context([
                'context' => $mailResponse->context,
                'subject' => $mailResponse->subject,
            ]);

        $this->mailer->send($email);
    }
}
