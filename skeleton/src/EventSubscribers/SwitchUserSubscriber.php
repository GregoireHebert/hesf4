<?php

declare(strict_types=1);

namespace App\EventSubscribers;

use Symfony\Component\Security\Http\Event\SwitchUserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\SecurityEvents;

/**
 * @author Grégoire Hébert <gregoire@les-tilleuls.coop>
 */
class SwitchUserSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            // constant for security.switch_user
            SecurityEvents::SWITCH_USER => 'onSwitchUser',
        );
    }

    public function onSwitchUser(SwitchUserEvent $event)
    {
        // perform any operation you need here.
        $event->getRequest()->getSession()->set(
            'username',
            // assuming your User has some getLocale() method
            $event->getTargetUser()->getUsername()
        );
    }
}
