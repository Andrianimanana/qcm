<?php

namespace App\EventSubscriber;

use App\Entity\Question;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class DatabaseActivitySubscriber implements EventSubscriber
{

    public  function getSubscribedEvents()
    {
        return [
            Events::postPersist,
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity     =  $args->getObject();
        $em         =  $args->getObjectManager();

        if($entity instanceof Question ){
            $max    =  $em->getRepository(Question::class)->findMaxIndexQuestion($entity);
            $entity->setIndexQuestion( intval(max($max)) + 1 );
            $em->flush();
        }
    }
}
