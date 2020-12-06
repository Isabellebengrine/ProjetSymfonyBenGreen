<?php

namespace App\Repository;

use App\Entity\Rubrique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rubrique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rubrique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rubrique[]    findAll()
 * @method Rubrique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RubriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rubrique::class);
    }

    // /**
    //  * @return Rubrique[] Returns an array of Rubrique objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @return Rubrique[]
     */
    public function findRubriqueWithNoParent(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Rubrique r
            WHERE r.parent is null
            ORDER BY r.rubriqueName ASC'
        );

        // returns an array of Rubrique objects that represent the main product rubriques :
        return $query->getResult();
    }

    /**
     * This method is called to find product categories with id of their parent category
    */
    public function findWithParent(int $parent): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Rubrique r
            WHERE r.parent = :parent
            ORDER BY r.rubriqueName ASC'
        )->setParameter('parent', $parent);

        // returns an array of Rubrique objects that represent the first 8 main product rubriques :
        return $query->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Rubrique
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
