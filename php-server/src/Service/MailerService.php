<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function sendEmail($to, $subject, $text)
    {
        $email = (new Email())
            ->from('info@fruit.com')
            ->to($to)
            ->subject($subject)
            ->text($text);
        $this->mailer->send($email);
    }
}
