<?php

namespace App\Repository;

use App\Entity\Gategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gategories[]    findAll()
 * @method Gategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gategories::class);
    }

    // /**
    //  * @return Gategories[] Returns an array of Gategories objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Gategories
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
