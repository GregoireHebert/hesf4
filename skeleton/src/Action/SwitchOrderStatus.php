<?php

declare(strict_types=1);

namespace App\Action;

use App\Entity\PlacedOrder;
use App\Repository\PlacedOrderRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route(name="orders_item_switch_status", path="/orders/{id}/{status}")
 * @Security("is_granted('ROLE_ADMIN')" )
 */
class SwitchOrderStatus
{
    public function __invoke(
        PlacedOrder $placedOrder,
        string $status,
        PlacedOrderRepository $placedOrderRepository,
        RouterInterface $router
    ) {
        try {
            $placedOrder->setStatus($status);
            $placedOrderRepository->save($placedOrder);

            return new RedirectResponse(
                $router->generate('orders_get_item', ['id'=>$placedOrder->getNumber()]),
                308
            );
        } catch (\InvalidArgumentException $e) {
            throw new BadRequestHttpException('The status is not supported.');
        }
    }
}
