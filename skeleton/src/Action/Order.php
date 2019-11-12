<?php

declare(strict_types=1);

namespace App\Action;

use App\Entity\PlacedOrder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * @Route(name="orders_get_item", path="/orders/{id}")
 */
class Order
{
    public function __invoke(PlacedOrder $order, Environment $twig)
    {
        return new Response($twig->render('order.html.twig', ['order'=>$order]));
    }
}
