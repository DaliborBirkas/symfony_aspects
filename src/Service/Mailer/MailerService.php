<?php

namespace App\Service\Mailer;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

class MailerService
{
    private const EMAIL_COMPANY = 'korisnicka.podrska@berzatransporta.rs';
    private const EMAIL_TITLE = 'Verifikacioni link';

    public function __construct(
        #[Autowire('%env(MAILER_DSN)%')]
        private string $dsn,
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(User $user, string $confirmationLink): void
    {
        $email = (new TemplatedEmail())
            ->to($user->getEmail())
            ->subject(self::EMAIL_TITLE)
            ->from(self::EMAIL_COMPANY)
            ->html('Poštovani,<br> ovo je verifikacioni email.<br> Kliknite na link ->  <a href="'.$confirmationLink.'">'.$confirmationLink.'</a>
               
                <br>
                <br>
                <br>
                <br>
                Korisnička podrška<br>
                Berza transporta<br>
                korisnicka.podrska@berzatransporta.rs<br>
                +381 65 77 99
                 ');

        $transport = Transport::fromDsn($this->dsn);
        $mailer = new Mailer($transport);
        $mailer->send($email);
    }
}