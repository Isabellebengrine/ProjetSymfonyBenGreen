<?php

namespace App\Repository;

use App\Entity\Orderdetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Orderdetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orderdetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orderdetail[]    findAll()
 * @method Orderdetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderdetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orderdetail::class);
    }

     /**
      * @return Orderdetail[] Returns an array of Orderdetail objects
      */
    public function findByTotalorder($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.totalorder = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Orderdetail
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
