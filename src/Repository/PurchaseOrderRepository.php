<?php

namespace App\Repository;

use App\Entity\PurchaseOrder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method PurchaseOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method PurchaseOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method PurchaseOrder[]    findAll()
 * @method PurchaseOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseOrderRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    ) {
        parent::__construct($registry, PurchaseOrder::class);
        $this->manager = $manager;
    }

    public function getLastById($id)
    {
        # code...
        $entityManager = $this->getEntityManager();

        $query = $entityManager
            ->createQuery(
                'SELECT p
            FROM App\Entity\PurchaseOrder p
            WHERE p.status = 1
            and p.buyer_id = :id
            limit 1'
            )
            ->setParameter('id', $id);

        // returns an array of Product objects
        return $query->getResult();
    }

    // /**
    //  * @return PurchaseOrder[] Returns an array of PurchaseOrder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PurchaseOrder
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
