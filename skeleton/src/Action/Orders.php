<?php

declare(strict_types=1);

namespace App\Action;

use App\Repository\PlacedOrderRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * @Route(name="orders", path="/orders")
 */
class Orders
{

    public function __invoke(PlacedOrderRepository $placedOrderRepository, Environment $twig)
    {
        $orders = $placedOrderRepository->getTotal();

        return new Response($twig->render('orders.html.twig', ['orders'=>$orders]));
    }
}
