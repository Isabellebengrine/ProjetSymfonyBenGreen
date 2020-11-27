<?php

namespace App\Repository;

use App\Entity\Supplierstype;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Supplierstype|null find($id, $lockMode = null, $lockVersion = null)
 * @method Supplierstype|null findOneBy(array $criteria, array $orderBy = null)
 * @method Supplierstype[]    findAll()
 * @method Supplierstype[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupplierstypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Supplierstype::class);
    }

    // /**
    //  * @return Supplierstype[] Returns an array of Supplierstype objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Supplierstype
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
