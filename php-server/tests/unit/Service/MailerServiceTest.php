<?php

declare(strict_types=1);

namespace App\Tests\unit\Service;

use PHPUnit\Framework\TestCase;
use App\Service\MailerService;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class MailerServiceTest extends TestCase
{
    private MailerInterface $mailer;
    private MailerService $mailerService;

    protected function setUp(): void
    {
        $this->mailer = $this->createMock(MailerInterface::class);
        $this->mailerService = new MailerService($this->mailer);
    }

    public function testSendEmail(): void
    {
        $to = 'test@example.com';
        $subject = 'Test email';
        $text = 'This is a test email';
        $email = (new Email())
            ->from('info@fruit.com')
            ->to($to)
            ->subject($subject)
            ->text($text);

        $this->mailer->expects($this->once())
            ->method('send')
            ->with($email);

        $this->mailerService->sendEmail($to, $subject, $text);
    }
}
