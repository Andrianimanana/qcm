<?php

/**
 * @Author: Armel <arbandry@gmail.com>
 */

namespace App\EventSubscriber; 

use App\Entity\User;
use App\Event\UserRegistrationEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\Mime\Email;

class RegistrationSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $admin_email;
    
    public function __construct(\Swift_Mailer $mailer, $admin_email){
        $this->mailer       = $mailer;
        $this->admin_email  = $admin_email;
    }

    public function onSendMailRegistration(UserRegistrationEvent $userEvent)//
    {
       $user    = $userEvent->getUser();
       $message = (new \Swift_Message('Hello Email'))
           ->setFrom($user->getEmail())
           ->setTo($this->admin_email)
           ->setBody(
               '<h1>Nouveau utilisateur :'.$user->getEmail().' </h1>',
               'text/html'
           );

       $this->mailer->send($message); 
    }

    public static function getSubscribedEvents()
    {
        return [
            UserRegistrationEvent::NAME => 'onSendMailRegistration',
        ];
    }
}
