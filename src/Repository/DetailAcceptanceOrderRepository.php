<?php

namespace App\Repository;

use App\Entity\DetailAcceptanceOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailAcceptanceOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailAcceptanceOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailAcceptanceOrder[]    findAll()
 * @method DetailAcceptanceOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailAcceptanceOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailAcceptanceOrder::class);
    }

    // /**
    //  * @return DetailAcceptanceOrder[] Returns an array of DetailAcceptanceOrder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetailAcceptanceOrder
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
