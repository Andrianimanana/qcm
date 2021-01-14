<?php

/**
 * @Author: Armel <arbandry@gmail.com>
 */

namespace App\EventSubscriber; 

use App\Entity\User;
use App\Event\UserRegistrationEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class RegistrationSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $admin_email;
    public function __construct(MailerInterface $mailer, $admin_email){
        $this->mailer       = $mailer;
        $this->admin_email  = $admin_email;
    }

    public function onSendMailRegistration(UserRegistrationEvent $userEvent)//
    {
       $user    = $userEvent->getUser();
       $email   = (new Email())
            ->from($user->getEmail())
            ->to($this->admin_email)
            ->subject('Utilisateur : <'.$user->getEmail().'>')
            ->html('<h1>Nouveau utilisateur :'.$user->getEmail().' </h1>');
        $this->mailer->send($email);
    }

    public static function getSubscribedEvents()
    {
        return [
            UserRegistrationEvent::NAME => 'onSendMailRegistration',
        ];
    }
}
