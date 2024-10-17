<?php

namespace App;

use App\Exception\NotVerifiedAuthenticationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

class VerifiedUserListener implements EventSubscriberInterface
{
    public function __construct(
        private readonly RouterInterface $router
    )
    {

    }

    public function onCheckPassport(CheckPassportEvent $event): void
    {
        $passport = $event->getPassport();
        $user = $passport->getUser();
        if (!$user->isVerified())
        {
//            throw new CustomUserMessageAuthenticationException('Molim vas verifikujte nalog.');
            throw new NotVerifiedAuthenticationException();
        }
    }

    public function onLoginFailure(LoginFailureEvent $failureEvent): void
    {
        if (!$failureEvent->getException() instanceof NotVerifiedAuthenticationException)
        {
            return;
        }

        $response = new RedirectResponse($this->router->generate('app_resend_verification_email'));
        $failureEvent->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', -5],
            LoginFailureEvent::class => ['onLoginFailure'],
        ];
    }
}