<?php

declare(strict_types=1);

namespace App\EventSubscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class SpecificEnvironmentSubscriber implements EventSubscriberInterface
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public static function getSubscribedEvents()
    {
       return [
            KernelEvents::REQUEST => ['addSpecificEnvironment']
       ];
    }

    public function addSpecificEnvironment(GetResponseEvent $event): void
    {
        $request = $event->getRequest();

        if (null !== $env = $request->query->get('env')) {
            $this->twig->addGlobal('specific_info', $env);
        }
    }
}
