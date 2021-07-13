<?php


namespace App\Controller\Front;

use App\Entity\article;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="frontArticleList")
     */
    public function articleList(ArticleRepository $articleRepository) //l'autowire
    {
        //Repository permet de faire des requete Select en bdd c'est pour cela que j'utilie l'autowire en intancie cette class
        $articles = $articleRepository->findAll();
        return $this->render('Front/List/frontArticleList.html.twig', [
            'articles' => $articles
        ]);

    }

    /**
     * @Route("/articles/{id}", name="frontArticleShow")//utilisation de la wildcard =>
     */
    public function articleShow($id, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->find($id);

        //Si le Base n'existe pas => renvoie une error exception en affichant erreur 404
        if (is_null($article)) {
           throw new NotFoundHttpException();
        };

        return $this->render('Front/Show/frontArticleShow.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    //Request permet de faire des modification dns l'url directement
    public function search(ArticleRepository $articleRepository, Request $request)
        /*l'utilisation de l'autowire pour intancier (ArticleRepository $articleRepository) et je recupere la bdd
        ArticleRepository permet de faire des requetes SELECT*/
    {
        $term = $request->query->get('q');
        //q = nom de recherche

        $articles = $articleRepository->searchByTerm($term);

        return $this->render('articleSearch.html.twig', [
            'articles' => $articles,
            'term' => $term
        ]);
    }

}