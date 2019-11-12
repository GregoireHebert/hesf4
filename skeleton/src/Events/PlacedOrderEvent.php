<?php

declare(strict_types=1);

namespace App\Events;

use App\Entity\PlacedOrder;
use Symfony\Contracts\EventDispatcher\Event;

final class PlacedOrderEvent extends Event
{
    private $order;

    public function __construct(PlacedOrder $order)
    {
        $this->order = $order;
    }

    public function getOrder(): PlacedOrder
    {
        return $this->order;
    }

    public function setOrder(PlacedOrder $order): void
    {
        $this->order = $order;
    }
}
