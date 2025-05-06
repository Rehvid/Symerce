<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Admin\Response\Mail\MailResponseDTO;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

readonly class MailService
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
            ->htmlTemplate('emails/'.$mailResponseDTO->template)
            ->locale('pl')
            ->context([
                'context' => $mailResponseDTO->context,
                'subject' => $mailResponseDTO->subject,
            ]);

        $this->mailer->send($email);
    }
}
