<?php

/**
 * @Author: Armel Andrianimanana
 * @Date:   2021-01-11 14:07:33
 * @Last Modified by:   Armel
 * @Last Modified time: 2021-01-11 15:43:38
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
    
    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
    }

    public function onSendMailRegistration(UserRegistrationEvent $userEvent)//
    {
       $user    = $userEvent->getUser();
       $email   = (new Email())
            ->from('arbandry@gmail.com')
            ->to('arbandry@gmail.com')
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
