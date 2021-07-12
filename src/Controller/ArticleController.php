<?php


namespace App\Controller;

use App\Entity\article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articleList")
     */
    public function articleList(ArticleRepository $articleRepository) //l'autowire
    {
        $articles = $articleRepository->findAll();
        return $this->render('articleList.html.twig', [
            'articles' => $articles
        ]);

    }

    /**
     * @Route("/articles/{id}", name="articleShow")//utilisation de la wildcard =>
     */
    public function articleShow($id, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->find($id);

        //Si le tag n'existe pas => renvoie une error exception en affichant erreur 404
        //if (is_null($article)) {
           // throw new NotFoundHttpException();
        //};

        return $this->render('articleShow.html.twig', [
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

    /**
     * @Route("/articles/insert", name="articleInsert")
     */
    public function insertArticle(EntityManagerInterface $entityManager)
    {
        //je cree une variable de stockage comme si je faisais un inser into dans la bdd
        $article = new Article();

        //ici je genere des setter afin d'ajouter les new valeurs dans les champs (=> donc propriétés)
        $article->Settitle('Lac Rose');
        $article->Setcontent('C’est l’un des lieux les plus connus du pays.');
        $article->SetcreateAt(new\DateTime('NOW'));
        $article->SetisPublished(true);

        //La methode "persist" permet d'effectuer un pré-sauvegarde
        $entityManager->persist($article);

        //ici j'insere dns la bdd grace la methode "flush"
        $entityManager->flush();

        dump('inseré'); die;
    }

    /**
     * @Route("/articles/update{id}", name="articleUpdate")
     */
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);
        //j'effectue une modification (update) sur le titre
        $article->setTitle("Bladade en dromadaire");

        //La methode "persist" permet d'effectuer un pré-sauvegarde
        $entityManager->persist($article);

        //ici j'insere dns la bdd grace la methode "flush"
        $entityManager->flush();

        return new Response('modification effectué');
    }

}