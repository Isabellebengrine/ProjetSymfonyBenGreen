<?php

namespace App\Repository;

use App\Entity\Categorietva;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categorietva|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorietva|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorietva[]    findAll()
 * @method Categorietva[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorietvaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorietva::class);
    }

    // /**
    //  * @return Categorietva[] Returns an array of Categorietva objects
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
    public function findOneBySomeField($value): ?Categorietva
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
