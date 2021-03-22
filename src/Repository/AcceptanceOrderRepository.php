<?php

namespace App\Repository;

use App\Entity\AcceptanceOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AcceptanceOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcceptanceOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcceptanceOrder[]    findAll()
 * @method AcceptanceOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcceptanceOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcceptanceOrder::class);
    }

    // /**
    //  * @return AcceptanceOrder[] Returns an array of AcceptanceOrder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AcceptanceOrder
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
