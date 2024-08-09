<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Recipe>
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function paginateRecipes(int $page): PaginationInterface
    {
         return $this->paginator->paginate($this->createQueryBuilder('r'),
         $page,
         20
        );
        
        // return new Paginator($this
        // ->createQueryBuilder('r')
        // ->setFirstResult(($page - 1) * $limit)
        // ->setMaxResults ($limit)
        // ->getQuery ()
        // ->setHint(Paginator:: HINT_ENABLE_DISTINCT, false),false
        // );
        
    }

    //    /**
    //     * @return Recipe[] Returns an array of Recipe objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Recipe
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }



    /**
     * Summary of findWithDuration
     * @return Recipe[]
     */
    public function findWithDuration(int $duration): array
    {
        
        return $this->createQueryBuilder('r')
       
        ->where('r.duration <= :duration')
        ->orderBy('r.duration','ASC')
        // ->setMaxResults(5)

        ->setParameter('duration',$duration)
        ->getQuery()
        ->getResult();
        
    }
}
