<?php

declare(strict_types=1);

namespace App\EventSubscribers;

use App\Events\PlacedOrderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PlacedOrderSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PlacedOrderEvent::class => 'onPlacedOrder'
        ];
    }

    public function onPlacedOrder(PlacedOrderEvent $placedOrderEvent): void
    {
        $order = $placedOrderEvent->getOrder();

        $content = 'Hi '.$order->getName().PHP_EOL.PHP_EOL;

        foreach ($order->getSelections() as $selection)
        {
            $content .= $selection->getProduct(). ' x'.$selection->getQuantity().PHP_EOL;
        }

        $message = new \Swift_Message(
            'McDo Order '.$order->getStatus(),
            $content,
            'text/plain'
        );
        $message->setFrom('38bf5b8704-66ad5b@inbox.mailtrap.io');
        $message->setTo('38bf5b8704-66ad5b@inbox.mailtrap.io');

        $this->mailer->send($message);
    }
}
