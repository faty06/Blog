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
        //alias permet de donner un nom, un alias à ta table
        $queryBuilder = $this->createQueryBuilder('article');
        //la variable term permet faire des recherches = variable de stockage
        //$term = 'Afrique';

        $query = $queryBuilder //constructeur de requete
            ->select('article') //je fais un requete select comme dns SQL

            ->leftJoin('article.category', 'category')
            //ici la FK de la table article (category et Base)
            ->leftJoin('article.Base', 'Base')

            //where permet de filter le mot souhaite
            ->where('article.content LIKE :term')
            ->orWhere('article.title LIKE :term')
            ->orWhere('category.title LIKE :term')
            ->orWhere('Base.title LIKE :term')
            //orWhere()

            /*setParameter permet de securiser la requete afin d'eviter
             les injections SQL (que qlqn envoie une requete SQL en recherche)*/
            ->setParameter('term', '%'.$term. '%')
            ->getQuery();

        return $query->getResult();
    }

}
