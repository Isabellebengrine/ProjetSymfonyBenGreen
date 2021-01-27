<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Products::class);
        $this->paginator = $paginator;
    }

    /**
     * This method is called to find products with id of their category (=rubrique) :
     */
    public function findWithRubrique(int $rubriqueid): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Products p
            WHERE p.rubrique = :rubriqueid
            ORDER BY p.productsName ASC'
        )->setParameter('rubriqueid', $rubriqueid);

        // returns an array of products objects that represent the products in this category (named rubrique in database) :
        return $query->getResult();
    }

    /**
     * Method returns products from a search
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search): PaginationInterface
    {
        $query = $this->getSearchQuery($search)->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            9
        );
    }

    /**
     * Returns min and max price values entered in a search
     * to use it in nouislider for price search
     * @param SearchData $search
     * @return int[]
     */
    public function findMinMax(SearchData $search): array
    {
         $results = $this->getSearchQuery($search, true)
            ->select('MIN(p.productsPrice) as min', 'MAX(p.productsPrice) as max')
            ->getQuery()
            ->getScalarResult();//returns a one line array with min and max keys and corresponding values
        return [(int)$results[0]['min'], (int)$results[0]['max']];
    }

    private function getSearchQuery(SearchData $search, $ignorePrice = false): QueryBuilder
    {
        $query = $this
            ->createQueryBuilder('p')   //we are getting products
            ->select('r', 'p')
            ->join('p.rubrique', 'r');

        if(!empty($search->q)){
            $query = $query
                ->andWhere('p.productsName LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if(!empty($search->min) && $ignorePrice === false){
            $query = $query
                ->andWhere('p.productsPrice >= :min')
                ->setParameter('min', $search->min);
        }

        if(!empty($search->max) && $ignorePrice === false){
            $query = $query
                ->andWhere('p.productsPrice <= :max')
                ->setParameter('max', $search->max);
        }

        if(!empty($search->rubriques)){
            $query = $query
                ->andWhere('r.parent IN (:rubriques)')
                ->setParameter('rubriques', $search->rubriques);
        }

        return $query;
    }

    // /**
    //  * @return Products[] Returns an array of Products objects
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
    public function findOneBySomeField($value): ?Products
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
