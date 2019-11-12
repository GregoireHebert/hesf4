<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\PlacedOrder;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class OrderColor Extends AbstractExtension
{
    private const COLOR_MAP = [
        PlacedOrder::STATUS_PREPARING => 'primary',
        PlacedOrder::STATUS_READY => 'danger',
        PlacedOrder::STATUS_TAKEN => 'secondary',
    ];

    public function getFilters(): array
    {
        return [
            new TwigFilter('orderColor', [$this, 'getOrderColor'])
        ];
    }

    public function getOrderColor(PlacedOrder $order): string
    {
        return self::COLOR_MAP[$order->getStatus()] ?? 'dark';
    }
}
