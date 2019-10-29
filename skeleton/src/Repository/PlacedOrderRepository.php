<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PlacedOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class PlacedOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlacedOrder::class);
    }

    public function persistAndSave(PlacedOrder $placedOrder): void
    {
        $manager = $this->getEntityManager();
        $manager->persist($placedOrder);
        $manager->flush();
    }
}
