<?php


namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/articles/{id}", name="articleShow")//utilisation de la wildcard
     */
    public function articleShow($id, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->find($id);

        //Si le tag n'existe pas => renvoie une error exception en affichant erreur 404
        if (is_null($article)) {
            throw new NotFoundHttpException();
        };

        return $this->render('articleShow.html.twig', [
            'article' => $article
        ]);

    }
}