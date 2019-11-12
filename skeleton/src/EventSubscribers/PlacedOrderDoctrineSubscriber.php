<?php

declare(strict_types=1);

namespace App\EventSubscribers;

use App\Contracts\DoctrineEventSubscriberInterface;
use App\Entity\PlacedOrder;
use App\Events\PlacedOrderEvent;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Psr\Log\LoggerInterface;

class PlacedOrderDoctrineSubscriber implements EventSubscriber, DoctrineEventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist
        ];
    }

    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $object = $eventArgs->getObject();
        if (!$object instanceof PlacedOrder) {
            return;
        }

        $this->logger->info('Order placed !', ['order' => $object]);
    }
}
