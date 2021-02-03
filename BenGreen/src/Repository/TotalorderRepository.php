<?php

namespace App\Repository;

use App\Entity\Totalorder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Totalorder|null find($id, $lockMode = null, $lockVersion = null)
 * @method Totalorder|null findOneBy(array $criteria, array $orderBy = null)
 * @method Totalorder[]    findAll()
 * @method Totalorder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TotalorderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Totalorder::class);
    }

     /**
      * @return Totalorder[] Returns an array of Totalorder objects
      */

    public function findByCustomer($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.customers = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Totalorder
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
