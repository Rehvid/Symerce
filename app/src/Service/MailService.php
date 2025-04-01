<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Response\Mail\MailResponseDTO;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

final readonly class MailService
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendMail(MailResponseDTO $mailResponseDTO): void
    {
        $email = (new TemplatedEmail())
            ->from('admin@symerce.com')
            ->to($mailResponseDTO->toEmail)
            ->subject($mailResponseDTO->subject)
            ->htmlTemplate('mail.html.twig')
            ->locale('pl')
            ->context([
                'context' => $mailResponseDTO->context,
            ]);

        $this->mailer->send($email);
    }
}
