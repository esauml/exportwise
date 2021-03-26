<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductSearch;
use App\Form\ProductSearchType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    ) {
        parent::__construct($registry, Product::class);
        $this->manager = $manager;
    }

    public function create(Product $newProduct)
    {
        $this->manager->persist($newProduct);
        $this->manager->flush();
    }

    public function update(Product $product): Product
    {
        $this->manager->persist($product);
        $this->manager->flush();

        return $product;
    }

    public function delete(Product $product)
    {
        $this->manager->remove($product);
        $this->manager->flush();
    }

    /**
     * @return Query
     */

    public function findAllVisibleQuery(ProductSearch $search): Query
    {
        $query = $this->findVisibleQuery();
        if ($search ->getMaxPrice()){
            $query = $query
                ->andWhere('p.price < :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }
        return $query->getQuery();
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.status = true');
    }

    /**
     * @return array
     */
    public function findLatest(): array
    {
        return $this->findAllVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();

    }
}
