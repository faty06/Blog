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
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminArticleController extends AbstractController
{
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

        //isValid permet
        if ($articleForm->isSubmitted() && $articleForm->isValid()){
            $this->addFlash('success', 'Votre article '.$article->getTitle().'a bien été créé !');
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('adminArticleList');
        }

        return $this->render('Admin/List/adminInsert.html.twig', [
            'articleForm' => $articleForm->createView()

        ]);
    }

    /**
     * @Route("/admin/articles/update/{id}", name="adminArticleUpdate")
     */
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager, SluggerInterface $slugger, Request $request)
    {
        $article = $articleRepository->find($id);
        //j'effectue une modification (update) sur le titre
        $article->setTitle("Bladade en dromadaire");

        $articleForm = $this->createForm(ArticleType::class, $article);

        //j'associe le formulaire
        $articleForm->handleRequest($request);

        if ($articleForm->isSubmitted() && $articleForm->isValid()){
            $imageFile = $articleForm->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);//creation d'un nom unique à partir du nom de l'img
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();//ajout d'un id unique au de l'img

                $imageFile->move(
                    $this->getParameter('imgArticle_directory'),
                    $newFilename
                );
                $article->setImage($newFilename);
            }

            $this->addFlash('success', 'Votre article '.$article->getTitle().'a bien été modifiée !');

            //La methode "persist" permet d'effectuer un pré-sauvegarde
            $entityManager->persist($article);
            //ici j'insere dns la bdd grace la methode "flush"
            $entityManager->flush();

            //prendre la route
            return $this->redirectToRoute('adminArticleList');

        }
        return $this->render('Admin/List/adminArticleUpdate.html.twig', [
            'articleForm' => $articleForm->createView()
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

        return $this->redirectToRoute('adminArticleList');
    }

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
}