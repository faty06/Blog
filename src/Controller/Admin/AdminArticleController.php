<?php


namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\tag;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AdminArticleController extends AbstractController
{
    /**
     * @Route("/admin/articles", name="adminArticleList")
     */
    public function articleList(ArticleRepository $articleRepository) //l'autowire
    {
        $articles = $articleRepository->findAll();
        return $this->render('Admin/List/adminArticleList.html.twig', [
            'articles' => $articles
        ]);

    }

    /**
     * @Route("/admin/articles/insert", name="adminArticleInsert")
     */
    public function insertArticle(Request $request, EntityManagerInterface $entityManager)
    {
        //L'entity Article permet de creer un new article en bdd comme si je faisais un inser into en sql
        $article = new Article();

        //je genere le formaire grace au gabarit puis j'intancie l'entity Article
        $articleForm = $this->createForm(ArticleType::class, $article);

        //j'associe le formulaire
        $articleForm->handleRequest($request);

        if ($articleForm->isSubmitted() && $articleForm->isValid()){
            $entityManager->persist($article);
            $entityManager->flush();

            //return $this->redirectToRoute('Admin/List/adminArticleList.html.twig');
        }

        return $this->render('Admin/List/adminInsert.html.twig', [
            'articleForm' => $articleForm->createView()
        ]);
    }

    /**
     * @Route("/admin/articles/update/{id}", name="adminArticleUpdate")
     */
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager, Request $request)
    {
        $article = $articleRepository->find($id);
        //j'effectue une modification (update) sur le titre
        $article->setTitle("Bladade en dromadaire");

        $articleForm = $this->createForm(ArticleType::class, $article);

        //j'associe le formulaire
        $articleForm->handleRequest($request);

        if ($articleForm->isSubmitted() && $articleForm->isValid()){
            //La methode "persist" permet d'effectuer un pré-sauvegarde
            $entityManager->persist($article);
            //ici j'insere dns la bdd grace la methode "flush"
            $entityManager->flush();

            //return $this->redirectToRoute('Admin/List/adminArticleList.html.twig');

        }
        return $this->render('Admin/List/adminArticleUpdate.html.twig', [
            'articleForm' => $articleForm->createView()
        ]);
    }

    /**
     * @Route("/admin/articles/{id}", name="adminArticleShow")//utilisation de la wildcard =>
     */
    public function articleShow($id, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->find($id);

        //Si le Base n'existe pas => renvoie une error exception en affichant erreur 404
        if (is_null($article)) {
            throw new NotFoundHttpException();
        };

        return $this->render('Admin/Show/adminArticleShow.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/admin/articles/delete/{id}", name="adminArticleDelete")
     */
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        //on effectue une suppression (delete) en ciblant l'id
        $article = $articleRepository->find($id);

        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('Admin/List/adminArticleList.html.twig');
    }

}