<?php

declare(strict_types=1);

namespace App\EventSubscribers;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @author Grégoire Hébert <gregoire@les-tilleuls.coop>
 */
class setHeaderSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
          KernelEvents::RESPONSE => 'myFunction'
        ];
    }

    public function myFunction(FilterResponseEvent $event)
    {
        $event->getResponse()->headers->set('MyHeader', 'MyValue');
    }
}
