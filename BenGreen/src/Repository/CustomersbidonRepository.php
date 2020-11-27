<?php

namespace App\Repository;

use App\Entity\Customersbidon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Customersbidon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customersbidon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customersbidon[]    findAll()
 * @method Customersbidon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomersbidonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customersbidon::class);
    }

    // /**
    //  * @return Customersbidon[] Returns an array of Customersbidon objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Customersbidon
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
