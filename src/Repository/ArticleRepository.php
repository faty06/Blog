<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function searchByTerm($term)
    {
        //alias permet de faire un habillage (article est un habillage)
        $queryBuilder = $this->createQueryBuilder('article');
        //la variable term permet faire des recherches
        $term = 'Sénégal';

        $query = $queryBuilder //constructeur de requete
            ->select('article') //je fais un requete select comme dns SQL

            //where permet de filter le mot souhaite
            ->where('article.content LIKE :term')
            //setParameter permet de securiser la requete afin d'eviter q'un malin marine le site
            ->setParameter('term', '%'.$term. '%')
            ->getQuery();

        return $query->getResult();
    }

}
