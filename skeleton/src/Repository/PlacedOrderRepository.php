<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PlacedOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\Mapping\RuntimeReflectionService;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\ResultSetMapping;

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

    public function save(PlacedOrder $placedOrder): void
    {
        $manager = $this->getEntityManager();
        $manager->flush($placedOrder);
    }

    public function getTotal()
    {
        $metadata = $this->getClassMetadata();
        $metadata->mapField([
            'fieldName' =>  'total',
            'type' =>  'integer',
            'columnName' =>  'total',
        ]);

        $metadata->wakeupReflection(new RuntimeReflectionService());

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult(PlacedOrder::class, 'ppo');
        $rsm->addFieldResult('ppo', 'number', 'number');
        $rsm->addFieldResult('ppo', 'status', 'status');
        $rsm->addFieldResult('ppo', 'name', 'name');
        $rsm->addFieldResult('ppo', 'total', 'total');

        $nativeQuery = $this->getEntityManager()->createNativeQuery(<<<SQL
SELECT ppo.*,
        (SELECT SUM(s.quantity * p.price) as selection_total
         FROM placed_order po
                  LEFT JOIN placed_order_selection pos ON pos.placed_order_id = po.number
                  LEFT JOIN selection s ON s.id = pos.selection_id
                  LEFT JOIN product p ON p.id = s.product_id
         WHERE po.number = ppo.number) as total
FROM placed_order ppo;
SQL
        , $rsm);

        return $nativeQuery->getResult();
    }
}
